<?php

namespace Src\WorkOrder\Application\UseCases;

use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\WorkOrder\Application\DTOs\WorkOrderDetailsResponseDTO;
use Src\WorkOrder\Application\Mappers\WorkOrderMapper;
use Src\WorkOrder\Domain\Exceptions\WorkOrderNotFoundException;
use Src\WorkOrder\Domain\Exceptions\WorkOrderNotInProgressException;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCompletedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;

class CompleteWorkOrderUseCase
{
    public function __construct(
        private WorkOrderRepositoryInterface $workOrderRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute($id): WorkOrderDetailsResponseDTO
    {
        $order = $this->workOrderRepo->findById($id);
        throw_if(!$order, WorkOrderNotFoundException::class);

        if ($order->getStatus()->value() !== 'in_progress') {
            throw new WorkOrderNotInProgressException();
        }

        $updatedOrder = $order;

        $updatedOrder = $updatedOrder
            ->changeStatus(new WorkOrderStatus('completed'))
            ->changeCompletedAt(new WorkOrderCompletedAt());

        $updated = $this->workOrderRepo->update($updatedOrder);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'work_order',
            targetId: $updated->getId(),
            eventType: 'completed',
            description: 'Orden de trabajo completada',
            meta: [
                'order_number' => $updated->getOrderNumber()->value(),
                'title' => $updated->getTitle(),
                'type' => $updated->getType()->value()
            ]
        );

        return WorkOrderMapper::toDetailsDto($updated, 'Work order completed successfully.');
    }
}
