<?php

namespace Src\Location\Domain\ValueObject;

use InvalidArgumentException;

class LocationType
{
    private const VALID_TYPES = [
        'building'      => 'Edificio',
        'room'          => 'Sala',
        'floor'         => 'Planta',
        'warehouse'     => 'Almacén',
        'datacenter'    => 'Centro de Datos',
        'outdoor'       => 'Exterior',
        'parking'       => 'Parking',
        'rooftop'       => 'Azotea',
    ];

    private string $value;

    public function __construct(string $value)
    {
        if (!array_key_exists($value, self::VALID_TYPES)) {
            throw new InvalidArgumentException("Invalid location type: $value");
        }

        $this->value = $value;
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
