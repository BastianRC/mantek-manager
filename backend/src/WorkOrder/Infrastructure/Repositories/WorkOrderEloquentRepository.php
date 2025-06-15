<?php

namespace Src\WorkOrder\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Src\WorkOrder\Domain\Entities\WorkOrder;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;
use Src\WorkOrder\Domain\ValueObject\WorkOrderNumber;
use Src\WorkOrder\Infrastructure\Mappers\WorkOrderEntityMapper;
use Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models\WorkOrderEloquent;

class WorkOrderEloquentRepository implements WorkOrderRepositoryInterface
{
    public function findAll(): array
    {
        $orders = WorkOrderEloquent::with([
            'materials',
            'assignee',
            'machine',
            'location',
            'createdBy',
            'updatedBy'
        ])->get();

        return $orders->map(
            fn($model) => WorkOrderEntityMapper::toDomain($model)
        )->all();
    }

    public function findById(int $id): ?WorkOrder
    {
        $model = WorkOrderEloquent::with([
            'materials',
            'assignee',
            'machine',
            'location',
            'createdBy',
            'updatedBy'
        ])->find($id);

        return $model ? WorkOrderEntityMapper::toDomain($model) : null;
    }

    public function create(WorkOrder $order): WorkOrder
    {
        $model = WorkOrderEntityMapper::toModel($order);
        $model->save();

        $model->order_number = WorkOrderNumber::fromId($model->id)->value();
        $model->save();

        foreach ($order->getMaterials() as $material) {
            $model->materials()->create([
                'material_name' => $material->getMaterialName(),
                'quantity' => $material->getQuantity(),
                'unit' => $material->getUnit()->value(),
            ]);
        }

        return WorkOrderEntityMapper::toDomain($model->fresh([
            'materials',
            'assignee',
            'machine',
            'location',
            'createdBy',
            'updatedBy'
        ]));
    }

    public function update(WorkOrder $order): WorkOrder
    {
        $model = WorkOrderEntityMapper::toModel($order);
        $model->save();

        DB::transaction(function () use ($model, $order) {
            $model->materials()->delete();

            foreach ($order->getMaterials() as $material) {
                $model->materials()->create([
                    'material_name' => $material->getMaterialName(),
                    'quantity' => $material->getQuantity(),
                    'unit' => $material->getUnit()->value(),
                ]);
            }
        });

        return WorkOrderEntityMapper::toDomain($model->fresh([
            'materials',
            'assignee',
            'machine',
            'location',
            'createdBy',
            'updatedBy'
        ]));
    }

    public function delete(WorkOrder $order): void
    {
        $model = WorkOrderEloquent::findOrFail($order->getId());
        $model->delete();
    }
}
