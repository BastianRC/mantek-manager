<?php

namespace Src\WorkOrder\Domain\Repositories;

use Src\WorkOrder\Domain\Entities\WorkOrderMaterial;

interface WorkOrderMaterialRepositoryInterface
{
    /**
     * @return WorkOrderMaterial[]
     */
    public function findAllByWorkOrderId(int $workOrderId): array;

    public function findById(int $id): ?WorkOrderMaterial;

    public function create(WorkOrderMaterial $material): WorkOrderMaterial;

    public function update(WorkOrderMaterial $material): WorkOrderMaterial;

    public function delete(WorkOrderMaterial $material): void;
}
