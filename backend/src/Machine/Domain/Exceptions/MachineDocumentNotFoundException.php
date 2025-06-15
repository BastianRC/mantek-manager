<?php

namespace Src\Machine\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class MachineDocumentNotFoundException extends DomainException
{
    public function __construct(string $message = 'Machine document not found.') 
    {
        parent::__construct($message, 404);
    }
}
