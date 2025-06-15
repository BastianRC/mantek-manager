<?php

namespace Src\Machine\Infrastructure\Repositories;

use Illuminate\Database\QueryException;
use Src\Machine\Domain\Entities\MachineType;
use Src\Machine\Domain\Exceptions\MachineTypeInUseException;
use Src\Machine\Domain\Repositories\MachineTypeRepositoryInterface;
use Src\Machine\Infrastructure\Mappers\MachineTypeEntityMapper;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineTypeEloquent;

class MachineTypeEloquentRepository implements MachineTypeRepositoryInterface
{
    public function findAll(): array
    {
        return MachineTypeEloquent::with(['createdBy', 'updatedBy'])
            ->get()
            ->map(fn($model) => MachineTypeEntityMapper::toDomain($model))
            ->all();
    }

    public function findById(int $id): ?MachineType
    {
        $model = MachineTypeEloquent::with(['createdBy', 'updatedBy'])->find($id);

        return $model ? MachineTypeEntityMapper::toDomain($model) : null;
    }

    public function create(MachineType $type): MachineType
    {
        $model = MachineTypeEntityMapper::toModel($type);
        $model->save();

        return MachineTypeEntityMapper::toDomain($model);
    }

    public function update(MachineType $type): MachineType
    {
        $model = MachineTypeEntityMapper::toModel($type);
        $model->save();

        return MachineTypeEntityMapper::toDomain($model);
    }

    public function delete(MachineType $type): void
    {
        try {
            $model = MachineTypeEloquent::findOrFail($type->getId());
            $model->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                throw new MachineTypeInUseException();
            }
        }
    }
}
