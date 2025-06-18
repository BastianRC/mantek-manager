<?php

namespace Src\WorkOrder\Infrastructure\Mappers;

use Src\Location\Infrastructure\Mappers\LocationEntityMapper;
use Src\Machine\Infrastructure\Mappers\MachineCategoryEntityMapper;
use Src\Machine\Infrastructure\Mappers\MachineEntityMapper;
use Src\User\Infrastructure\Mappers\UserEntityMapper;
use Src\WorkOrder\Domain\Entities\WorkOrderEntity;
use Src\WorkOrder\Domain\Entities\WorkOrderMaterialEntity;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCompletedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCreatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderDueAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderEstimatedHours;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialUnit;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPausedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPriority;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStartedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;
use Src\WorkOrder\Domain\ValueObject\WorkOrderType;
use Src\WorkOrder\Domain\ValueObject\WorkOrderUpdatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderNumber;
use Src\WorkOrder\Domain\ValueObject\WorkOrderResumedAt;
use Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models\WorkOrderEloquent;

class WorkOrderEntityMapper
{
    public static function toDomain(WorkOrderEloquent $model): WorkOrderEntity
    {
        return new WorkOrderEntity(
            id: $model->id,
            orderNumber: new WorkOrderNumber($model->order_number),
            title: $model->title,
            type: new WorkOrderType($model->type),
            description: $model->description,
            priority: new WorkOrderPriority($model->priority),
            status: new WorkOrderStatus($model->status),
            dueAt: new WorkOrderDueAt($model->due_at),
            estimatedHours: new WorkOrderEstimatedHours($model->estimated_hours),
            pausedAt: $model->paused_at ? new WorkOrderPausedAt($model->paused_at) : null,
            startedAt: $model->started_at ? new WorkOrderStartedAt($model->started_at) : null,
            completedAt: $model->completed_at ? new WorkOrderCompletedAt($model->completed_at) : null,
            resumedAt: $model->resumed_at ? new WorkOrderResumedAt($model->resumed_at) : null,
            actualHours: $model->actual_hours,
            assignee: $model->assignee ? UserEntityMapper::toDomain($model->assignee) : null,
            machine: $model->machine ? MachineEntityMapper::toDomain($model->machine) : null,
            location: LocationEntityMapper::toDomain($model->location),
            materials: $model->materials
                ? array_map(fn($m) => new WorkOrderMaterialEntity(
                    id: $m->id,
                    workOrderId: $m->work_order_id,
                    materialName: $m->material_name,
                    quantity: $m->quantity,
                    unit: new WorkOrderMaterialUnit($m->unit),
                ), $model->materials->all())
                : [],
            requestedBy: $model->requested_by,
            approvedBy: $model->approved_by,
            notes: $model->notes,
            createdBy: $model->createdBy ? UserEntityMapper::toDomain($model->createdBy) : null,
            updatedBy: $model->updatedBy ? UserEntityMapper::toDomain($model->updatedBy) : null,
            createdAt: new WorkOrderCreatedAt($model->created_at),
            updatedAt: new WorkOrderUpdatedAt($model->updated_at)
        );
    }

    public static function toModel(WorkOrderEntity $entity): WorkOrderEloquent
    {
        $model = $entity->isPersisted()
            ? WorkOrderEloquent::findOrFail($entity->getId())
            : new WorkOrderEloquent();

        $model->order_number = $entity->getOrderNumber()->value();
        $model->title = $entity->getTitle();
        $model->type = $entity->getType()->value();
        $model->description = $entity->getDescription();
        $model->priority = $entity->getPriority()->value();
        $model->status = $entity->getStatus()->value();
        $model->due_at = $entity->getDueAt()->value();
        $model->estimated_hours = $entity->getEstimatedHours()->value();
        $model->paused_at = $entity->getPausedAt()?->value();
        $model->started_at = $entity->getStartedAt()?->value();
        $model->completed_at = $entity->getCompletedAt()?->value();
        $model->actual_hours = $entity->getActualHours();

        $model->assignee_id = $entity->getAssignee()?->getId();
        $model->machine_id = $entity->getMachine()?->getId();
        $model->location_id = $entity->getLocation()->getId();

        $model->requested_by = $entity->getRequestedBy();
        $model->approved_by = $entity->getApprovedBy();
        $model->notes = $entity->getNotes();

        $model->created_by = $entity->getCreatedBy()?->getId();
        $model->updated_by = $entity->getUpdatedBy()?->getId();

        return $model;
    }
}
