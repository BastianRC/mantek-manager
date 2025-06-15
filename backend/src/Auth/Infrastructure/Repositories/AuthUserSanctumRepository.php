<?php

namespace Src\Auth\Infrastructure\Repositories;

use Src\Auth\Domain\Entity\AuthUser;
use Src\Auth\Domain\Repositories\AuthUserRepositoryInterface;
use Src\Auth\Infrastructure\Mappers\AuthUserEntityMapper;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

class AuthUserSanctumRepository  implements AuthUserRepositoryInterface
{
    public function findByEmail(string $email): ?AuthUser
    {
        $user = UserEloquent::where('email', $email)->first();

        return $user ? AuthUserEntityMapper::toDomain($user) : null;
    }

    public function createToken(AuthUser $user): string
    {
        $model = UserEloquent::findOrFail($user->getId());

        return $model->createToken('auth_token')->plainTextToken;
    }

    public function deleteToken(): void
    {
        request()->user()?->currentAccessToken()?->delete();
    }
}
