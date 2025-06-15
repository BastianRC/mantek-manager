<?php

namespace Src\Shared\Domain\ValueObjects;


use DateTimeImmutable;
use InvalidArgumentException;

abstract class BaseDateTime
{
    protected DateTimeImmutable $value;

    public function __construct(string|DateTimeImmutable|null $value = null)
    {
        if ($value instanceof DateTimeImmutable) {
            $this->value = $value;
        } elseif (is_string($value)) {
            try {
                $this->value = new DateTimeImmutable($value);
            } catch (\Exception $e) {
                throw new InvalidArgumentException('Invalid Date: ' . $value);
            }
        } else {
            $this->value = new DateTimeImmutable();
        }
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    public function toString(string $format = 'Y-m-d H:i:s'): string
    {
        return $this->value->format($format);
    }

    public function equals(BaseDateTime $other): bool
    {
        return $this->value == $other->value();
    }
}
