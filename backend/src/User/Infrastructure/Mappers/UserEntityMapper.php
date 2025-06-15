<?php

namespace Src\User\Infrastructure\Mappers;

use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Src\User\Domain\Entity\UserEntity;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserLastLogin;
use Src\User\Domain\ValueObject\UserUpdatedAt;


class UserEntityMapper
{
    public static function toDomain(UserEloquent $model): UserEntity
    {
        return new UserEntity(
            id: $model->id,
            firstName: $model->first_name,
            lastName: $model->last_name,
            email: new UserEmail($model->email),
            role: $model->roles()->pluck('name')->first(),
            phone: $model->phone,
            password: new HashedUserPassword($model->password),
            department: $model->department,
            notes: $model->notes,
            avatarUrl: $model->avatar_url,
            isActive: $model->is_active,
            lastLogin: $model->last_login ? new UserLastLogin($model->last_login) : null,
            createdAt: new UserCreatedAt($model->created_at),
            updatedAt: new UserUpdatedAt($model->updated_at),
            createdBy: null,
            updatedBy: null,
        );
    }

    public static function toModel(UserEntity $entity): UserEloquent
    {
        $model = $entity->isPersisted()
            ? UserEloquent::findOrFail($entity->getId())
            : new UserEloquent();

        $model->first_name = $entity->getFirstName();
        $model->last_name = $entity->getLastName();
        $model->email = $entity->getEmail()->value();
        $model->phone = $entity->getPhone();
        $model->password = $entity->getPassword()->value();
        $model->department = $entity->getDepartment();
        $model->notes = $entity->getNotes();
        $model->avatar_url = $entity->getAvatarUrl();
        $model->is_active = $entity->isActive();
        
        $model->last_login = $entity->getLastLogin()?->value();
        $model->created_at = $entity->getCreatedAt()->value();
        $model->updated_at = $entity->getUpdatedAt()->value();

        $model->created_by = $entity->getCreatedBy()?->getId();
        $model->updated_by = $entity->getUpdatedBy()?->getId();

        return $model;
    }
}
