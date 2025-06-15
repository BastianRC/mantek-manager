<?php

namespace Src\Location\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class LocationNotFoundException extends DomainException
{
    public function __construct(string $message = 'Location not found.') 
    {
        parent::__construct($message, 404);
    }
}
