<?php

namespace Src\Auth\Domain\Repositories;

use Src\Auth\Domain\Entity\AuthUser;

interface AuthUserRepositoryInterface
{
    public function findByEmail(string $email): ?AuthUser;
    public function createToken(AuthUser $user): string;
    public function deleteToken(): void;
}