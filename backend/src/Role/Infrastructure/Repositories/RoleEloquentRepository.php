<?php

namespace Src\Role\Infrastructure\Repositories;

use Src\Role\Domain\Entities\Permission;
use Src\Role\Domain\Entities\Role;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;
use Src\Role\Infrastructure\Mappers\RoleEntityMapper;
use Src\Role\Infrastructure\Persistence\Eloquent\Models\RoleEloquent;

class RoleEloquentRepository implements RoleRepositoryInterface
{
    public function findAll(): array
    {
        return RoleEloquent::with('permissions')
            ->withCount('users')
            ->get()
            ->map(fn($model) => RoleEntityMapper::toDomain($model))
            ->all();
    }

    public function findById(int $id): ?Role
    {
        $model = RoleEloquent::with(['permissions', 'users', 'createdBy', 'updatedBy'])->find($id);

        return $model ? RoleEntityMapper::toDomain($model) : null;
    }

    public function findByName(string $name): ?Role
    {
        $model = RoleEloquent::with(['permissions', 'users', 'createdBy', 'updatedBy'])
            ->where('name', $name)
            ->first();

        return $model ? RoleEntityMapper::toDomain($model) : null;
    }

    public function create(Role $role): Role
    {
        $model = RoleEntityMapper::toModel($role);
        $model->save();

        // asignar permisos
        $model->permissions()->sync(
            array_map(fn(Permission $p) => $p->getId(), $role->getPermissions())
        );

        return RoleEntityMapper::toDomain($model->load(['permissions', 'users', 'createdBy', 'updatedBy']));
    }

    public function update(Role $role): Role
    {
        $model = RoleEntityMapper::toModel($role);
        $model->save();

        $model->permissions()->sync(
            array_map(fn(Permission $p) => $p->getId(), $role->getPermissions())
        );

        return RoleEntityMapper::toDomain($model->load(['permissions', 'users', 'createdBy', 'updatedBy']));
    }

    public function delete(Role $role): void
    {
        $model = RoleEloquent::findOrFail($role->getId());
        $model->delete();
    }

    public function syncPermissions(Role $role, array $permissions): void
    {
        $model = RoleEloquent::findOrFail($role->getId());

        $model->permissions()->sync(
            array_map(fn(Permission $p) => $p->getId(), $permissions)
        );
    }
}
