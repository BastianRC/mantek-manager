<?php

namespace Src\WorkOrder\Application\UseCases;

use Src\WorkOrder\Application\DTOs\AllWorkOrdersResponseDTO;
use Src\WorkOrder\Application\Mappers\WorkOrderMapper;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;

class GetWorkOrdersListUseCase
{
    public function __construct(
        private WorkOrderRepositoryInterface $repo
    ) {}

    public function execute(): AllWorkOrdersResponseDTO
    {
        $orders = $this->repo->findAll();
        return WorkOrderMapper::toCollection($orders);
    }
}