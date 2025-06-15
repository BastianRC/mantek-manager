<?php

namespace Src\Machine\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class MachineTypeNotFoundException extends DomainException
{
    public function __construct(string $message = 'Machine type not found.') 
    {
        parent::__construct($message, 404);
    }
}
