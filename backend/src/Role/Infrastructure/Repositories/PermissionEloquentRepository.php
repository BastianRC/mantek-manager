<?php

namespace Src\Role\Infrastructure\Repositories;

use Src\Role\Domain\Entities\Permission;
use Src\Role\Domain\Repositories\PermissionRepositoryInterface;
use Src\Role\Infrastructure\Mappers\PermissionEntityMapper;
use Src\Role\Infrastructure\Persistence\Eloquent\Models\PermissionEloquent;

class PermissionEloquentRepository implements PermissionRepositoryInterface
{
    public function findAll(): array
    {
        return PermissionEloquent::all()
            ->map(fn(PermissionEloquent $model) => PermissionEntityMapper::toDomain($model))
            ->all();
    }

    public function findById(int $id): ?Permission
    {
        $model = PermissionEloquent::find($id);

        return $model ? PermissionEntityMapper::toDomain($model) : null;
    }

    public function findByName(string $name): ?Permission
    {
        $model = PermissionEloquent::where('name', $name)->first();

        return $model ? PermissionEntityMapper::toDomain($model) : null;
    }
}
