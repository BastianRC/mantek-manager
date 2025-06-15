<?php

namespace Src\Machine\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class MachineCategoryInUseException extends DomainException
{
    public function __construct(string $message = 'Machine category is in use and cannot be deleted.') 
    {
        parent::__construct($message, 409);
    }
}
