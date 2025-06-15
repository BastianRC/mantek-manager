<?php

namespace Src\WorkOrder\Domain\Repositories;

use Src\WorkOrder\Domain\Entities\WorkOrder;

interface WorkOrderRepositoryInterface
{
    /** 
     * @return WorkOrder[] 
     */
    public function findAll(): array;

    public function findById(int $id): ?WorkOrder;

    public function create(WorkOrder $order): WorkOrder;

    public function update(WorkOrder $order): WorkOrder;

    public function delete(WorkOrder $order): void;
}
