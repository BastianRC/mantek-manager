<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class WorkOrderAlreadyPausedException extends DomainException
{
    public function __construct(string $message = 'This work order is already paused.')
    {
        parent::__construct($message, 409);
    }
}
