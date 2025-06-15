<?php

namespace Src\Auth\Infrastructure\Mappers;

use Src\Auth\Domain\Entity\AuthUser;
use Src\Auth\Domain\Entity\AuthUserEntity;
use Src\Auth\Domain\ValueObject\HashedUserPassword;
use Src\Auth\Domain\ValueObject\UserEmail;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

class AuthUserEntityMapper
{
    public static function toDomain(UserEloquent $model): AuthUser
    {
        return new AuthUserEntity(
            id: $model->id,
            email: new UserEmail($model->email),
            name: trim($model->first_name . ' ' . $model->last_name),
            role: $model->getRoleNames()->first() ?? 'no-role',
            permissions: $model->getAllPermissions()->pluck('name')->toArray(),
            password: new HashedUserPassword($model->password),
        );
    }
}
