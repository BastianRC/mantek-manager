<?php

namespace Src\Machine\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class MachineNotFoundException extends DomainException
{
    public function __construct(string $message = 'Machine not found.') 
    {
        parent::__construct($message, 404);
    }
}
