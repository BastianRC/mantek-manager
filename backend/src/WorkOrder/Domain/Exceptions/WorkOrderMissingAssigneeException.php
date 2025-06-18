<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class WorkOrderMissingAssigneeException extends DomainException
{
    public function __construct(string $message = 'A work order without a technician can only be in "pending" status.')
    {
        parent::__construct($message, 400);
    }
}
