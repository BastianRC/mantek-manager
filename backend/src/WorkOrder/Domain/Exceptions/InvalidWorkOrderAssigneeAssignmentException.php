<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class InvalidWorkOrderAssigneeAssignmentException extends DomainException
{
    public function __construct(string $message = 'Cannot assign a technician unless the initial status is "assigned".')
    {
        parent::__construct($message, 400);
    }
}
