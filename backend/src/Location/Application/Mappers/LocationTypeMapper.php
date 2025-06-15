<?php

namespace Src\Location\Application\Mappers;

use Src\Location\Application\DTOs\AllLocationTypesResponseDTO;
use Src\Location\Application\DTOs\LocationTypeOptionDTO;
use Src\Location\Domain\ValueObject\LocationSystemType;
use Src\Location\Domain\ValueObject\LocationType;

class LocationTypeMapper
{
    public static function toCollectionDto(): AllLocationTypesResponseDTO
    {
        $types = array_map(
            fn($value, $label) => new LocationTypeOptionDTO($value, $label),
            LocationType::validTypes(),
            LocationType::validTypesWithLabels()
        );

        return new AllLocationTypesResponseDTO(
            success: true,
            message: 'Location types retrieved successfully.',
            types: $types
        );
    }
}
