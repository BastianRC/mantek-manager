<?php

namespace Src\Role\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class RoleAlreadyExistsException extends DomainException
{
    public function __construct(string $message = 'A role with this name already exists.')
    {
        parent::__construct($message, 400);
    }
}