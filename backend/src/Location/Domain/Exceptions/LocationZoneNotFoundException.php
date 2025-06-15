<?php

namespace Src\Location\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\DomainException;

class LocationZoneNotFoundException extends DomainException
{
    public function __construct(string $message = 'Location zone not found.') 
    {
        parent::__construct($message, 404);
    }
}
