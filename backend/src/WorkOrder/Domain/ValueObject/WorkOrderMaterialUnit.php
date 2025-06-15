<?php

namespace Src\WorkOrder\Domain\ValueObject;

use InvalidArgumentException;

class WorkOrderMaterialUnit
{
    private const ALLOWED_UNITS = [
        'kg',
        'g',
        'l',
        'ml',
        'pcs',
        'm',
        'cm',
        'unit',
    ];

    public function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::ALLOWED_UNITS)) {
            throw new InvalidArgumentException("Invalid material unit: $value");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function validUnits(): array
    {
        return self::ALLOWED_UNITS;
    }
}
