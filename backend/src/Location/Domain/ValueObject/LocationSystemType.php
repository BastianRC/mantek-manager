<?php

namespace Src\Location\Domain\ValueObject;

use InvalidArgumentException;

class LocationSystemType
{
    private const VALID_TYPES = [
        'climatizacion' => 'Climatización',
        'seguridad' => 'Seguridad',
        'incendios' => 'Incendios',
        'energia' => 'Energía',
        'red_datos' => 'Red de datos',
    ];

    public function __construct(
        private readonly string $value
    ) {
        if (!array_key_exists($value, self::VALID_TYPES)) {
            throw new InvalidArgumentException("Invalid location system type: $value");
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
