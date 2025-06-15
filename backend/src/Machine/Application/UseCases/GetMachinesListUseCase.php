<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\DTOs\AllMachinesResponseDTO;
use Src\Machine\Application\Mappers\MachineMapper;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;

class GetMachinesListUseCase
{
    public function __construct(
        private readonly MachineRepositoryInterface $repo
    ) {}

    public function execute(): AllMachinesResponseDTO
    {
        $machines = $this->repo->findAll();
        return MachineMapper::toCollectionDto($machines);
    }
}
