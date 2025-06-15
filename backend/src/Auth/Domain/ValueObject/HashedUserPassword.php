<?php

namespace Src\Auth\Domain\ValueObject;

use InvalidArgumentException;

class HashedUserPassword
{
    public function __construct(
        private string $password
    ) {
        if (!preg_match('/^\$2[ayb]\$.{56}$/', $password)) {
            throw new InvalidArgumentException("Password must be a valid bcrypt hash.");
        }
    }

    public function value(): string
    {
        return $this->password;
    }

    public function matches(string $plain): bool
    {
        return password_verify($plain, $this->password);
    }
}
