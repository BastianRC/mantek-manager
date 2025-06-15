<?php

namespace Src\WorkOrder\Domain\ValueObject;

use InvalidArgumentException;

class WorkOrderEstimatedHours
{
    public function __construct(
        private readonly float $value
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException("Estimated hours must be a positive number.");
        }
    }

    public function value(): float
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value();
    }
}
