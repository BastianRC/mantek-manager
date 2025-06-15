<?php

namespace Src\Role\Infrastructure\Mappers;

use Src\Role\Domain\Entities\PermissionEntity;
use Src\Role\Infrastructure\Persistence\Eloquent\Models\PermissionEloquent;

class PermissionEntityMapper
{
    public static function toDomain(PermissionEloquent $model): PermissionEntity
    {
        return new PermissionEntity(
            id: $model->id,
            name: $model->name,
        );
    }
}
