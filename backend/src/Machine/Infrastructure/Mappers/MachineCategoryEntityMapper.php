<?php

namespace Src\Machine\Infrastructure\Mappers;

use Src\Machine\Domain\Entities\MachineCategoryEntity;
use Src\Machine\Domain\ValueObject\MachineCategoryCreatedAt;
use Src\Machine\Domain\ValueObject\MachineCategoryUpdatedAt;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineCategoryEloquent;

use Src\User\Infrastructure\Mappers\UserEntityMapper;

class MachineCategoryEntityMapper
{
    public static function toDomain(MachineCategoryEloquent $model): MachineCategoryEntity
    {
        return new MachineCategoryEntity(
            id: $model->id,
            name: $model->name,
            createdBy: $model->createdBy ? UserEntityMapper::toDomain($model->createdBy) : null,
            updatedBy: $model->updatedBy ? UserEntityMapper::toDomain($model->updatedBy) : null,
            createdAt: new MachineCategoryCreatedAt($model->created_at),
            updatedAt: new MachineCategoryUpdatedAt($model->updated_at),
        );
    }

    public static function toModel(MachineCategoryEntity $category): MachineCategoryEloquent
    {
        $model = $category->isPersisted()
            ? MachineCategoryEloquent::findOrFail($category->getId())
            : new MachineCategoryEloquent();

        $model->name = $category->getName();
        $model->created_by = $category->getCreatedBy()?->getId();
        $model->updated_by = $category->getUpdatedBy()?->getId();
        $model->created_at = $category->getCreatedAt()->value();
        $model->updated_at = $category->getUpdatedAt()->value();

        return $model;
    }
}
