<?php

namespace Src\Machine\Domain\Repositories;

use Src\Machine\Domain\Entities\Machine;

interface MachineRepositoryInterface
{
    /**
     * @return Machine[]
     */
    public function findAll(): array;
    public function findById(int $id): ?Machine;
    public function create(Machine $machine): Machine;
    public function update(Machine $machine): Machine;
    public function delete(Machine $machine): void;
}
