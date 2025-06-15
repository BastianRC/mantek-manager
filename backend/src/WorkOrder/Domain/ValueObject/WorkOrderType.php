<?php

namespace Src\WorkOrder\Domain\ValueObject;

use InvalidArgumentException;

class WorkOrderType
{
    private const VALID_TYPES = [
        'corrective'   => 'Correctiva',
        'preventive'   => 'Preventiva',
        'predictive'   => 'Predictiva',
        'inspection'   => 'Inspección',
        'improvement'  => 'Mejora',
        'legal'        => 'Legal / Normativa',
        'installation' => 'Instalación',
        'cleaning'     => 'Limpieza técnica',
    ];

    public function __construct(
        private readonly string $value
    ) {
        if (!array_key_exists($value, self::VALID_TYPES)) {
            throw new InvalidArgumentException("Invalid work order type: $value");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function validTypes(): array
    {
        return array_keys(self::VALID_TYPES);
    }

    public static function validTypesWithLabels(): array
    {
        return self::VALID_TYPES;
    }
}
