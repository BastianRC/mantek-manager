<?php

namespace Src\Shared\Domain\Exceptions;

use RuntimeException;

abstract class DomainException extends RuntimeException
{
    protected int $statusCode;

    public function __construct(string $message = '', int $statusCode = 400)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message, $statusCode);
    }


    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
