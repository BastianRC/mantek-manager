<?php

namespace Src\WorkOrder\Infrastructure\Mappers;

use Src\WorkOrder\Domain\Entities\WorkOrderMaterialEntity;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialUnit;
use Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models\WorkOrderMaterialEloquent;

class WorkOrderMaterialEntityMapper
{
    public static function toDomain(WorkOrderMaterialEloquent $model): WorkOrderMaterialEntity
    {
        return new WorkOrderMaterialEntity(
            id: $model->id,
            materialName: $model->material_name,
            quantity: $model->quantity,
            unit: new WorkOrderMaterialUnit($model->unit),
            workOrderId: $model->work_order_id
        );
    }

    public static function toModel(WorkOrderMaterialEntity $entity): WorkOrderMaterialEloquent
    {
        $model = $entity->isPersisted()
            ? WorkOrderMaterialEloquent::findOrFail($entity->getId())
            : new WorkOrderMaterialEloquent();

        $model->material_name = $entity->getMaterialName();
        $model->quantity = $entity->getQuantity();
        $model->unit = $entity->getUnit()->value();
        $model->work_order_id = $entity->getWorkOrderId();

        return $model;
    }
}
