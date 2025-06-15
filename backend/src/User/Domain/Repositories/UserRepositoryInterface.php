<?php

namespace Src\User\Domain\Repositories;

use Src\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function create(User $user): User;

    public function update(User $user): User;

    public function delete(User $user): void;

    public function assignRole(User $user, string $role): void;
}
