<?php

namespace Src\WorkOrder\Application\UseCases;

use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\WorkOrder\Domain\Exceptions\WorkOrderNotFoundException;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;

class DeleteWorkOrderUseCase
{
    public function __construct(
        private WorkOrderRepositoryInterface $repo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(int $id): BaseResponseDto 
    {
        $order = $this->repo->findById($id);

        throw_if(!$order, WorkOrderNotFoundException::class);

        $this->repo->delete($order);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'work_order',
            targetId: $order->getId(),
            eventType: 'deleted',
            description: 'Orden de trabajo eliminada',
            meta: []
        );

        return ResponseMapper::toDto('Work order deleted successfully.');
    }
}
