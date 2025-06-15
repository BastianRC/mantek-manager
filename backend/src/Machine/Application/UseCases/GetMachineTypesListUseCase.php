<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\Mappers\MachineTypeMapper;
use Src\Machine\Domain\Repositories\MachineTypeRepositoryInterface;

class GetMachineTypesListUseCase
{
    public function __construct(
        private readonly MachineTypeRepositoryInterface $repo
    ) {}

    public function execute()
    {
        $types = $this->repo->findAll();

        return MachineTypeMapper::toCollectionDto($types);
    }
}
