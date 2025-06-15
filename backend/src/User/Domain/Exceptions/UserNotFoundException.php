<?php

namespace Src\User\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class UserNotFoundException extends DomainException
{
    public function __construct(string $message = 'User not found.')
    {
        parent::__construct($message, 404);
    }
}