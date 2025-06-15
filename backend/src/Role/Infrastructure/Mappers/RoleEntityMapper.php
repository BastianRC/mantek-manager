<?php

namespace Src\Role\Infrastructure\Mappers;

use Src\Role\Domain\Entities\PermissionEntity;
use Src\Role\Domain\Entities\Role;
use Src\Role\Domain\Entities\RoleEntity;
use Src\Role\Domain\ValueObject\RoleCreatedAt;
use Src\Role\Domain\ValueObject\RoleUpdatedAt;
use Src\Role\Infrastructure\Persistence\Eloquent\Models\RoleEloquent;
use Src\User\Infrastructure\Mappers\UserEntityMapper;

class RoleEntityMapper
{
    public static function toDomain(RoleEloquent $model): RoleEntity
    {
        return new RoleEntity(
            id: $model->id,
            name: $model->name,
            description: $model->description,
            color: $model->color,
            isActive: $model->is_active,
            permissions: $model->permissions
                ->map(fn($perm) => new PermissionEntity($perm->id, $perm->name))
                ->all(),
            users: $model->users
                ->map(fn($user) => UserEntityMapper::toDomain($user))
                ->all(),
            createdBy: $model->createdBy
                ? UserEntityMapper::toDomain($model->createdBy)
                : null,
            updatedBy: $model->updatedBy
                ? UserEntityMapper::toDomain($model->updatedBy)
                : null,
            createdAt: new RoleCreatedAt($model->created_at),
            updatedAt: new RoleUpdatedAt($model->updated_at)
        );
    }

    public static function toModel(Role $entity): RoleEloquent
    {
        $model = $entity->isPersisted()
            ? RoleEloquent::findOrFail($entity->getId())
            : new RoleEloquent();

        $model->name = $entity->getName();
        $model->description = $entity->getDescription();
        $model->color = $entity->getColor();
        $model->is_active = $entity->isActive();

        $model->created_at = $entity->getCreatedAt()->value();
        $model->updated_at = $entity->getUpdatedAt()?->value();

        $model->created_by = $entity->getCreatedBy()?->getId();
        $model->updated_by = $entity->getUpdatedBy()?->getId();

        return $model;
    }
}
