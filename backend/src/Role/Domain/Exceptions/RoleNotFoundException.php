<?php

namespace Src\Role\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class RoleNotFoundException extends DomainException
{
    public function __construct(string $message = 'Role not found.') 
    {
        parent::__construct($message, 404);
    }
}
