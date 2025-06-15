<?php

namespace Src\WorkOrder\Application\UseCases;

use Src\Location\Domain\Exceptions\LocationNotFoundException;
use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Machine\Domain\Exceptions\MachineCategoryNotFoundException;
use Src\Machine\Domain\Exceptions\MachineNotFoundException;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\WorkOrder\Application\DTOs\CreateWorkOrderMaterialRequestDTO;
use Src\WorkOrder\Application\DTOs\CreateWorkOrderRequestDTO;
use Src\WorkOrder\Application\DTOs\WorkOrderDetailsResponseDTO;
use Src\WorkOrder\Application\Mappers\WorkOrderMapper;
use Src\WorkOrder\Domain\Entities\WorkOrderEntity;
use Src\WorkOrder\Domain\Entities\WorkOrderMaterialEntity;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCompletedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCreatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderDueAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderEstimatedHours;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialUnit;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPausedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPriority;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStartedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;
use Src\WorkOrder\Domain\ValueObject\WorkOrderType;
use Src\WorkOrder\Domain\ValueObject\WorkOrderUpdatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderNumber;

class CreateWorkOrderUseCase
{
    public function __construct(
        private readonly WorkOrderRepositoryInterface $workOrderRepo,
        private readonly UserRepositoryInterface $userRepo,
        private readonly MachineRepositoryInterface $machineRepo,
        private readonly LocationRepositoryInterface $locationRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(CreateWorkOrderRequestDTO $dto): WorkOrderDetailsResponseDTO
    {
        $createdBy = $this->userRepo->findById($dto->createdBy);
        throw_if(!$createdBy, UserNotFoundException::class);

        $assignee = $dto->assigneeId ? $this->userRepo->findById($dto->assigneeId) : null;
        throw_if($dto->assigneeId && !$assignee, UserNotFoundException::class);

        $machine = $dto->machineId ? $this->machineRepo->findById($dto->machineId) : null;
        throw_if($dto->machineId && !$machine, MachineNotFoundException::class);

        $location = $this->locationRepo->findById($dto->locationId);
        throw_if(!$location, LocationNotFoundException::class);

        $order = new WorkOrderEntity(
            id: 0,
            orderNumber: WorkOrderNumber::temp(),
            title: $dto->title,
            type: new WorkOrderType($dto->type),
            description: $dto->description,
            priority: new WorkOrderPriority($dto->priority),
            status: new WorkOrderStatus($dto->status),
            dueAt: new WorkOrderDueAt($dto->dueAt),
            estimatedHours: new WorkOrderEstimatedHours($dto->estimatedHours),
            pausedAt: $dto->pausedAt ? new WorkOrderPausedAt($dto->pausedAt) : null,
            startedAt: $dto->startedAt ? new WorkOrderStartedAt($dto->startedAt) : null,
            completedAt: $dto->completedAt ? new WorkOrderCompletedAt($dto->completedAt) : null,
            actualHours: null,
            assignee: $assignee,
            machine: $machine ?? null,
            location: $location,
            materials: array_map(
                fn($m) => new WorkOrderMaterialEntity(
                    id: 0,
                    workOrderId: 0,
                    materialName: $m['material_name'],
                    quantity: $m['quantity'],
                    unit: new WorkOrderMaterialUnit($m['unit']),
                ),
                $dto->materials
            ),
            requestedBy: $dto->requestedBy,
            approvedBy: $dto->approvedBy,
            notes: $dto->notes,
            createdBy: $createdBy,
            updatedBy: $createdBy,
            createdAt: new WorkOrderCreatedAt(),
            updatedAt: new WorkOrderUpdatedAt()
        );

        $created = $this->workOrderRepo->create($order);

        $this->chronologyLogger->log(
            user: $createdBy,
            targetType: 'work_order',
            targetId: $created->getId(),
            eventType: 'created',
            description: 'Orden de trabajo creada',
            meta: [
                'order_number' => $created->getOrderNumber()->value(),
                'title' => $created->getTitle(),
                'type' => $created->getType()->value()
            ]
        );

        return WorkOrderMapper::toDetailsDto($created, 'Work order created successfully.');
    }
}
