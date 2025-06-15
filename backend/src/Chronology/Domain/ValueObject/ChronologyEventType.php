<?php

namespace Src\Chronology\Domain\ValueObject;

use InvalidArgumentException;

class ChronologyEventType
{
    private const VALID_TYPES = [
        'created'     => 'Creado',
        'updated'     => 'Actualizado',
        'deleted'     => 'Eliminado',
        'assigned'    => 'Asignado',
        'started'     => 'Iniciado',
        'paused'      => 'Pausado',
        'canceled'    => 'Cancelado',
        'completed'   => 'Completado',
        'commented'   => 'Comentado',
        'activated'   => 'Activado',
        'deactivated' => 'Desactivado',
    ];

    private string $value;

    public function __construct(string $value)
    {
        if (!array_key_exists($value, self::VALID_TYPES)) {
            throw new InvalidArgumentException("Invalid chronology event type: $value");
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
