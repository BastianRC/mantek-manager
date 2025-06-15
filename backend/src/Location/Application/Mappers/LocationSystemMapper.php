<?php

namespace Src\Location\Application\Mappers;

use Src\Location\Application\DTOs\AllLocationSystemsResponseDTO;
use Src\Location\Application\DTOs\LocationSystemOptionDTO;
use Src\Location\Application\DTOs\LocationSystemResponseDTO;
use Src\Location\Domain\Entity\LocationSystem;
use Src\Location\Domain\ValueObject\LocationSystemType;

class LocationSystemMapper
{
    public static function toCollectionDto(): AllLocationSystemsResponseDTO
    {
        $systems = array_map(
            fn($value, $label) => new LocationSystemOptionDTO($value, $label),
            LocationSystemType::validTypes(),
            LocationSystemType::validTypesWithLabels()
        );

        return new AllLocationSystemsResponseDTO(
            success: true,
            message: 'Location systems retrieved successfully.',
            systems: $systems
        );
    }
}
