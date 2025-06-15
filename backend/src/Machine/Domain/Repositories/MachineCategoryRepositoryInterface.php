<?php

namespace Src\Machine\Domain\Repositories;

use Src\Machine\Domain\Entities\MachineCategory;

interface MachineCategoryRepositoryInterface
{
    /**
     *
     * @return MachineCategory[]
     */
    public function findAll(): array;
    public function findById(int $id): ?MachineCategory;
    public function create(MachineCategory $category): MachineCategory;
    public function update(MachineCategory $category): MachineCategory;
    public function delete(MachineCategory $category): void;
}
