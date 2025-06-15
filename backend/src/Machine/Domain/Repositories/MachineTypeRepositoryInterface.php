<?php

namespace Src\Machine\Domain\Repositories;

use Src\Machine\Domain\Entities\MachineType;

interface MachineTypeRepositoryInterface
{
    /**
     * 
     * @return MachineType[]
     */
    public function findAll(): array;
    public function findById(int $id): ?MachineType;
    public function create(MachineType $type): MachineType;
    public function update(MachineType $type): MachineType;
    public function delete(MachineType $type): void;
}
