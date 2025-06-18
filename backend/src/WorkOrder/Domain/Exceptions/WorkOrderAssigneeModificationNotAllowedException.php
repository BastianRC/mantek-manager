<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class WorkOrderAssigneeModificationNotAllowedException extends DomainException
{
    public function __construct(string $message = 'Cannot modify the technician in the current state.')
    {
        parent::__construct($message, 409);
    }
}
