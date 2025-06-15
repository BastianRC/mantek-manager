<?php

namespace Src\Machine\Domain\ValueObject;

use InvalidArgumentException;

class MachineStatus
{
    private const VALID_STATUSES = [
        'operational',
        'maintenance',
        'warning',
        'critical',
        'retired',
    ];

    public function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::VALID_STATUSES)) {
            throw new InvalidArgumentException("Invalid machine status: $value");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function validStatuses(): array
    {
        return self::VALID_STATUSES;
    }
}
