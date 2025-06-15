<?php

namespace Src\WorkOrder\Domain\ValueObject;

use InvalidArgumentException;

class WorkOrderPriority
{
    private const VALID_PRIORITIES = [
        'low',
        'medium',
        'high',
        'critical',
    ];

    public function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::VALID_PRIORITIES)) {
            throw new InvalidArgumentException("Invalid work order priority: $value");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function validPriorities(): array
    {
        return self::VALID_PRIORITIES;
    }
}
