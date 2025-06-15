<?php

namespace Src\Machine\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class MachineCategoryNotFoundException extends DomainException
{
    public function __construct(string $message = 'Machine category not found.') 
    {
        parent::__construct($message, 404);
    }
}
