<?php

namespace Src\WorkOrder\Application\UseCases;

use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\WorkOrder\Application\DTOs\WorkOrderDetailsResponseDTO;
use Src\WorkOrder\Application\Mappers\WorkOrderMapper;
use Src\WorkOrder\Domain\Exceptions\InvalidWorkOrderPauseException;
use Src\WorkOrder\Domain\Exceptions\WorkOrderAlreadyPausedException;
use Src\WorkOrder\Domain\Exceptions\WorkOrderNotFoundException;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPausedAt;

class PauseWorkOrderUseCase
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
            throw new InvalidWorkOrderPauseException();
        }

        if ($order->getPausedAt() !== null) {
            throw new WorkOrderAlreadyPausedException();
        }

        $updatedOrder = $order;

        $now = new WorkOrderPausedAt();
        $lastResumedAt = $order->getResumedAt() ?? $order->getStartedAt();
        $hoursThisSession = $now->diffInHours($lastResumedAt);

        $updatedOrder = $order
            ->changePausedAt($now)
            ->changeActualHours($order->getActualHours() + $hoursThisSession);
            
        $updated = $this->workOrderRepo->update($updatedOrder);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'work_order',
            targetId: $updated->getId(),
            eventType: 'paused',
            description: 'Orden de trabajo pausada',
            meta: [
                'order_number' => $updated->getOrderNumber()->value(),
                'title' => $updated->getTitle(),
                'type' => $updated->getType()->value()
            ]
        );

        return WorkOrderMapper::toDetailsDto($updated, 'Work order paused successfully.');
    }
}
