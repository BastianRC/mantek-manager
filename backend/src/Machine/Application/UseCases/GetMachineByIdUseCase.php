<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\DTOs\MachineDetailsResponseDTO;
use Src\Machine\Application\Mappers\MachineMapper;
use Src\Machine\Domain\Exceptions\MachineNotFoundException;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;

class GetMachineByIdUseCase
{
    public function __construct(
        private readonly MachineRepositoryInterface $repo
    ) {}

    public function execute(int $id): MachineDetailsResponseDTO
    {
        $machine = $this->repo->findById($id);

        throw_if(!$machine, MachineNotFoundException::class);

        return MachineMapper::toDetailsDto($machine);
    }
}
