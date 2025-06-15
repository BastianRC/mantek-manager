<?php

namespace Src\Machine\Infrastructure\Mappers;

use Src\Machine\Domain\Entities\MachineTypeEntity;
use Src\Machine\Domain\ValueObject\MachineTypeCreatedAt;
use Src\Machine\Domain\ValueObject\MachineTypeUpdatedAt;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineTypeEloquent;
use Src\User\Infrastructure\Mappers\UserEntityMapper;

class MachineTypeEntityMapper
{
    public static function toDomain(MachineTypeEloquent $model): MachineTypeEntity
    {
        return new MachineTypeEntity(
            id: $model->id,
            name: $model->name,
            createdBy: $model->createdBy ? UserEntityMapper::toDomain($model->createdBy) : null,
            updatedBy: $model->updatedBy ? UserEntityMapper::toDomain($model->updatedBy) : null,
            createdAt: new MachineTypeCreatedAt($model->created_at),
            updatedAt: new MachineTypeUpdatedAt($model->updated_at),
        );
    }

    public static function toModel(MachineTypeEntity $entity): MachineTypeEloquent
    {
        $model = $entity->isPersisted()
            ? MachineTypeEloquent::findOrFail($entity->getId())
            : new MachineTypeEloquent();

        $model->name = $entity->getName();
        $model->created_by = $entity->getCreatedBy()?->getId();
        $model->updated_by = $entity->getUpdatedBy()?->getId();
        $model->created_at = $entity->getCreatedAt()->value();
        $model->updated_at = $entity->getUpdatedAt()->value();

        return $model;
    }
}
