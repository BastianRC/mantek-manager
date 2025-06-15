<?php

namespace Src\User\Domain\ValueObject;

use InvalidArgumentException;

class UserEmail
{
    public function __construct(
        private string $email
    ) {
        if (!preg_match('/^[^@\s]+@[^@\s]+\.[^@\s]+$/', $email)) {
            throw new InvalidArgumentException("Invalid email format: {$email}");
        }
    }

    public function value(): string
    {
        return $this->email;
    }
}
