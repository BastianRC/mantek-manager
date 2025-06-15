<?php

namespace Src\Machine\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class MachineTypeInUseException extends DomainException
{
    public function __construct(string $message = 'Machine type is in use and cannot be deleted.') 
    {
        parent::__construct($message, 409);
    }
}
