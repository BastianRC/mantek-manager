<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class InvalidWorkOrderStartException extends DomainException
{
    public function __construct(string $message = 'Work order can only be started or resumed from assigned or in_progress state.')
    {
        parent::__construct($message, 409);
    }
}
