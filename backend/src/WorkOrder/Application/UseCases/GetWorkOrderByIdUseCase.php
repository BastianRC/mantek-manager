<?php

namespace Src\WorkOrder\Application\UseCases;

use Src\WorkOrder\Application\DTOs\WorkOrderDetailsResponseDTO;
use Src\WorkOrder\Application\Mappers\WorkOrderMapper;
use Src\WorkOrder\Domain\Exceptions\WorkOrderNotFoundException;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;

class GetWorkOrderByIdUseCase
{
    public function __construct(
        private readonly WorkOrderRepositoryInterface $repo
    ) {}

    public function execute(int $id): WorkOrderDetailsResponseDTO
    {
        $order = $this->repo->findById($id);

        throw_if(!$order, WorkOrderNotFoundException::class);

        return WorkOrderMapper::toDetailsDto($order);
    }
}
