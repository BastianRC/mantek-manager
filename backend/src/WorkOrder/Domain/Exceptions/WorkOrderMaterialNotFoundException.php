<?php

namespace Src\WorkOrder\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class WorkOrderMaterialNotFoundException extends DomainException
{
    public function __construct(string $message = 'Work order material not found.')
    {
        parent::__construct($message, 404);
    }
}
