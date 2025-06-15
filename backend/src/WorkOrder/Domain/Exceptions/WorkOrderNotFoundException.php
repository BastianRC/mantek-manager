<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class WorkOrderNotFoundException extends DomainException
{
    public function __construct(string $message = 'Work order not found.')
    {
        parent::__construct($message, 404);
    }
}
