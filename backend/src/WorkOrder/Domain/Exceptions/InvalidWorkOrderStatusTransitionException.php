<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class InvalidWorkOrderStatusTransitionException extends DomainException
{
    public function __construct(string $current, string $new, string $message = "Cannot transition work order from $current to $new.")
    {
        parent::__construct($message, 400);
    }
}
