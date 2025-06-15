<?php

namespace Src\Machine\Infrastructure\Repositories;

use Src\Machine\Domain\Entities\Machine;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;
use Src\Machine\Infrastructure\Mappers\MachineEntityMapper;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineEloquent;

class MachineEloquentRepository implements MachineRepositoryInterface
{
    public function findAll(): array
    {
        return MachineEloquent::with(['type', 'category', 'location', 'workOrders.assignee', 'createdBy', 'updatedBy'])
            ->get()
            ->map(fn($model) => MachineEntityMapper::toDomain($model))
            ->all();
    }

    public function findById(int $id): ?Machine
    {
        $model = MachineEloquent::with(['type', 'category', 'location', 'workOrders.assignee', 'createdBy', 'updatedBy'])->find($id);

        return $model ? MachineEntityMapper::toDomain($model) : null;
    }

    public function create(Machine $machine): Machine
    {
        $model = MachineEntityMapper::toModel($machine);
        $model->save();

        return MachineEntityMapper::toDomain($model);
    }

    public function update(Machine $machine): Machine
    {
        $model = MachineEntityMapper::toModel($machine);
        $model->save();

        return MachineEntityMapper::toDomain($model);
    }

    public function delete(Machine $machine): void
    {
        $model = MachineEloquent::findOrFail($machine->getId());
        $model->delete();
    }
}
