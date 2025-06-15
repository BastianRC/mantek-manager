<?php

namespace Src\User\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class CannotDeleteLastSuperAdminException extends DomainException
{
    public function __construct($message = 'Cannot delete the last user with the super-admin role.')
    {
        parent::__construct($message, 403);
    }
}