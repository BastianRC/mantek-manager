<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class InvalidWorkOrderPauseException extends DomainException
{
    public function __construct(string $message = 'Only work orders in progress can be paused.')
    {
        parent::__construct($message, 409);
    }
}
