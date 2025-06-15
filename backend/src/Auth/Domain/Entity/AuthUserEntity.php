<?php

namespace Src\Auth\Domain\Entity;

use Src\Auth\Domain\ValueObject\HashedUserPassword;
use Src\Auth\Domain\ValueObject\UserEmail;

class AuthUserEntity implements AuthUser
{
    public function __construct(
        private int $id,
        private UserEmail $email,
        private string $name,
        private HashedUserPassword $password,
        private string $role,
        private array $permissions
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): HashedUserPassword
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
