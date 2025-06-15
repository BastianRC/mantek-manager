<?php

namespace Src\Chronology\Domain\ValueObject;

class ChronologyMeta
{
    public function __construct(private readonly array $value) {}

    public function value(): array
    {
        return $this->value;
    }
}
