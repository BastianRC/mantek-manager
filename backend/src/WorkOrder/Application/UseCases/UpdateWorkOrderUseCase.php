<?php

namespace Src\WorkOrder\Application\UseCases;

use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\WorkOrder\Application\DTOs\UpdateWorkOrderRequestDTO;
use Src\WorkOrder\Application\DTOs\WorkOrderDetailsResponseDTO;
use Src\WorkOrder\Application\Mappers\WorkOrderMapper;
use Src\WorkOrder\Domain\Entities\WorkOrderMaterialEntity;
use Src\WorkOrder\Domain\Exceptions\WorkOrderNotFoundException;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCompletedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderDueAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderEstimatedHours;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialUnit;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPausedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPriority;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStartedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;
use Src\WorkOrder\Domain\ValueObject\WorkOrderType;
use Src\WorkOrder\Domain\ValueObject\WorkOrderUpdatedAt;

class UpdateWorkOrderUseCase
{
    public function __construct(
        private WorkOrderRepositoryInterface $workOrderRepo,
        private UserRepositoryInterface $userRepo,
        private MachineRepositoryInterface $machineRepo,
        private LocationRepositoryInterface $locationRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(UpdateWorkOrderRequestDTO $dto): WorkOrderDetailsResponseDTO
    {
        $order = $this->workOrderRepo->findById($dto->id);
        throw_if(!$order, WorkOrderNotFoundException::class);

        $updatedOrder = $order;
        
        $map = [
            'title' => fn($o, $v) => $o->changeTitle($v),
            'type' => fn($o, $v) => $o->changeType(new WorkOrderType($v)),
            'description' => fn($o, $v) => $o->changeDescription($v),
            'status' => fn($o, $v) => $o->changeStatus(new WorkOrderStatus($v)),
            'priority' => fn($o, $v) => $o->changePriority(new WorkOrderPriority($v)),
            'dueAt' => fn($o, $v) => $o->changeDueAt(new WorkOrderDueAt($v)),
            'estimatedHours' => fn($o, $v) => $o->changeEstimatedHours(new WorkOrderEstimatedHours($v)),
            'pausedAt' => fn($o, $v) => $o->changePausedAt(new WorkOrderPausedAt($v)),
            'startedAt' => fn($o, $v) => $o->changeStartedAt(new WorkOrderStartedAt($v)),
            'completedAt' => fn($o, $v) => $o->changeCompletedAt(new WorkOrderCompletedAt($v)),
            'assigneeId' => fn($o, $v) => $o->changeAssignee($this->userRepo->findById($v)),
            'machineId' => fn($o, $v) => $o->changeMachine($this->machineRepo->findById($v)),
            'locationId' => fn($o, $v) => $o->changeLocation($this->locationRepo->findById($v)),
            'requestedBy' => fn($o, $v) => $o->changeRequestedBy($v),
            'approvedBy' => fn($o, $v) => $o->changeApprovedBy($v),
            'notes' => fn($o, $v) => $o->changeNotes($v),
            'updatedById' => fn($o, $v) => $o->changeUpdatedBy($this->userRepo->findById($v)),
        ];

        foreach ($map as $key => $callback) {
            if (!is_null($dto->$key)) {
                $updatedOrder = $callback($updatedOrder, $dto->$key === '' ? null : $dto->$key);
            }
        }

        if (!is_null($dto->materials)) {
            $materials = array_map(fn($m) => new WorkOrderMaterialEntity(
                id: $m['id'] ?? 0,
                workOrderId: $dto->id,
                materialName: $m['material_name'],
                quantity: $m['quantity'],
                unit: new WorkOrderMaterialUnit($m['unit']),
            ), $dto->materials);

            $updatedOrder = $updatedOrder->changeMaterials($materials);
        }

        $updatedOrder = $updatedOrder->changeUpdatedAt(new WorkOrderUpdatedAt());

        $updated = $this->workOrderRepo->update($updatedOrder);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'work_order',
            targetId: $updated->getId(),
            eventType: 'updated',
            description: 'Orden de trabajo actualizada',
            meta: [
                'order_number' => $updated->getOrderNumber()->value(),
                'title' => $updated->getTitle(),
                'type' => $updated->getType()->value()
            ]
        );

        return WorkOrderMapper::toDetailsDto($updated, 'Work order updated successfully.');
    }
}
