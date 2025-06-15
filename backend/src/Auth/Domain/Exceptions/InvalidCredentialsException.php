<?php

namespace Src\Auth\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class InvalidCredentialsException extends DomainException
{
    public function __construct(string $message = 'Invalid credentials')
    {
        parent::__construct($message, 401);
    }
}