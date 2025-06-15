<?php

namespace Src\Machine\Infrastructure\Repositories;

use Illuminate\Database\QueryException;
use Src\Machine\Domain\Entities\MachineCategory;
use Src\Machine\Domain\Exceptions\MachineCategoryInUseException;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Machine\Infrastructure\Mappers\MachineCategoryEntityMapper;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineCategoryEloquent;

class MachineCategoryEloquentRepository implements MachineCategoryRepositoryInterface
{
    public function findAll(): array
    {
        return MachineCategoryEloquent::with(['createdBy', 'updatedBy'])
            ->get()
            ->map(fn($model) => MachineCategoryEntityMapper::toDomain($model))
            ->all();
    }

    public function findById(int $id): ?MachineCategory
    {
        $model = MachineCategoryEloquent::with(['createdBy', 'updatedBy'])->find($id);

        return $model ? MachineCategoryEntityMapper::toDomain($model) : null;
    }

    public function create(MachineCategory $category): MachineCategory
    {
        $model = MachineCategoryEntityMapper::toModel($category);
        $model->save();

        return MachineCategoryEntityMapper::toDomain($model);
    }

    public function update(MachineCategory $category): MachineCategory
    {
        $model = MachineCategoryEntityMapper::toModel($category);
        $model->save();

        return MachineCategoryEntityMapper::toDomain($model);
    }

    public function delete(MachineCategory $category): void
    {
        try {
            $model = MachineCategoryEloquent::findOrFail($category->getId());
            $model->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                throw new MachineCategoryInUseException();
            }
        }
    }
}
