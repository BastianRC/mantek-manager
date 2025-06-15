<?php

namespace Src\User\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class CreateUserException extends DomainException
{
    public function __construct(string $message = 'An error occurred while creating the user.')
    {
        parent::__construct($message, 400);
    }
}
