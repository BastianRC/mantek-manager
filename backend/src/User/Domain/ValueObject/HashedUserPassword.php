<?php

namespace Src\User\Domain\ValueObject;

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
}
