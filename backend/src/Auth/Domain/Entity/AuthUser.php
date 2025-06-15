<?php

namespace Src\Auth\Domain\Entity;

use Src\Auth\Domain\ValueObject\HashedUserPassword;
use Src\Auth\Domain\ValueObject\UserEmail;

interface AuthUser
{
    public function getId(): int;
    public function getEmail(): UserEmail;
    public function getName(): string;
    public function getPassword(): HashedUserPassword;
    public function getRole(): string;
    public function getPermissions(): array;
}
