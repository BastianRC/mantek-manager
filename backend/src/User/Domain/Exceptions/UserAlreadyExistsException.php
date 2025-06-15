<?php

namespace Src\User\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class UserAlreadyExistsException extends DomainException
{
    public function __construct(string $message = 'Email already in use.')
    {
        parent::__construct($message, 409);
    }
}