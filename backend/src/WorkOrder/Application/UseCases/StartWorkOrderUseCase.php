<?php

namespace Src\WorkOrder\Application\UseCases;

use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\WorkOrder\Application\DTOs\WorkOrderDetailsResponseDTO;
use Src\WorkOrder\Application\Mappers\WorkOrderMapper;
use Src\WorkOrder\Domain\Exceptions\InvalidWorkOrderStartException;
use Src\WorkOrder\Domain\Exceptions\WorkOrderNotFoundException;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;
use Src\WorkOrder\Domain\ValueObject\WorkOrderResumedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStartedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;

class StartWorkOrderUseCase
{
    public function __construct(
        private WorkOrderRepositoryInterface $workOrderRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute($id): WorkOrderDetailsResponseDTO
    {
        $order = $this->workOrderRepo->findById($id);
        throw_if(!$order, WorkOrderNotFoundException::class);

        if (!in_array($order->getStatus()->value(), ['assigned', 'in_progress'])) {
            throw new InvalidWorkOrderStartException();
        }

        $updatedOrder = $order;

        if ($order->getStatus()->value() === 'assigned') {
            $updatedOrder = $updatedOrder
                ->changeStatus(new WorkOrderStatus('in_progress'))
                ->changeStartedAt(new WorkOrderStartedAt())
                ->changeResumedAt(null)
                ->changePausedAt(null);
        } else {
            $updatedOrder = $updatedOrder
                ->changeResumedAt(new WorkOrderResumedAt())
                ->changePausedAt(null);
        }

        $updated = $this->workOrderRepo->update($updatedOrder);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'work_order',
            targetId: $updated->getId(),
            eventType: 'started',
            description: 'Orden de trabajo iniciada',
            meta: [
                'order_number' => $updated->getOrderNumber()->value(),
                'title' => $updated->getTitle(),
                'type' => $updated->getType()->value()
            ]
        );

        return WorkOrderMapper::toDetailsDto($updated, 'Work order started successfully.');
    }
}
