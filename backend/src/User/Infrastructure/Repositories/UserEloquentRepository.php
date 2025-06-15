<?php

namespace Src\User\Infrastructure\Repositories;

use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Src\User\Domain\Entity\User;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Infrastructure\Mappers\UserEntityMapper;


class UserEloquentRepository implements UserRepositoryInterface
{
    public function findAll(): array
    {
        $models = UserEloquent::with(['roles', 'creator', 'updater'])->get();
        return $models->map(fn($model) => UserEntityMapper::toDomain($model))->all();
    }

    public function findById(int $id): ?User
    {
        $model = UserEloquent::with(['roles', 'creator', 'updater'])->find($id);
        return $model ? UserEntityMapper::toDomain($model) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $model = UserEloquent::with(['roles', 'creator', 'updater'])->where('email', $email)->first();
        return $model ? UserEntityMapper::toDomain($model) : null;
    }

    public function create(User $user): User
    {
        $model = UserEntityMapper::toModel($user);
        $model->save();

        $model->assignRole($user->getRole());

        $model->load('roles');

        return UserEntityMapper::toDomain($model);
    }

    public function update(User $user): User
    {
        $model = UserEntityMapper::toModel($user);
        $model->save();

        $model->assignRole($user->getRole());

        $model->load('roles');
        
        return UserEntityMapper::toDomain($model);
    }

    public function delete(User $user): void
    {
        $model = UserEloquent::findOrFail($user->getId());
        $model->delete();
    }

    public function assignRole(User $user, string $role): void
    {
        $model = UserEloquent::findOrFail($user->getId());

        try {
            $model->assignRole($role);
        } catch (RoleDoesNotExist $e) {
            throw $e;
        }
    }
}
