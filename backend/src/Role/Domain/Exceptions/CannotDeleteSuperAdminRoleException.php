<?php

namespace Src\Role\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class CannotDeleteSuperAdminRoleException extends DomainException
{
    public function __construct($message = 'The super admin role cannot be deleted.')
    {
        parent::__construct($message, 403);
    }
}
