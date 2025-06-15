<?php

namespace Src\WorkOrder\Domain\ValueObject;

use InvalidArgumentException;

class WorkOrderStatus
{
    private const VALID_STATUSES = [
        'pending',
        'assigned',
        'in_progress',
        'completed',
        'cancelled',
    ];

    public function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::VALID_STATUSES)) {
            throw new InvalidArgumentException("Invalid work order status: $value");
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
