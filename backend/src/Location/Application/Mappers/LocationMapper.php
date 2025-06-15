<?php

namespace Src\Location\Application\Mappers;

use Src\Location\Application\DTOs\AllLocationsResponseDTO;
use Src\Location\Application\DTOs\LocationDetailsResponseDTO;
use Src\Location\Application\DTOs\LocationResponseDTO;
use Src\Location\Domain\Entity\Location;

class LocationMapper
{
    public static function toDto(Location $location, string $message = 'Location retrieved successfully.'): LocationResponseDTO
    {
        return new LocationResponseDTO(
            success: true,
            message: $message,
            id: $location->getId(),
            name: $location->getName(),
            type: $location->getType(),
            description: $location->getDescription(),
            address: $location->getAddress(),
            managerName: $location->getManager()->getFullName(),
            isActive: $location->isActive(),
            machines: $location->getMachines(),
            workOrders: $location->getWorkOrders(),
            createdAt: $location->getCreatedAt(),
            updatedAt: $location->getUpdatedAt()
        );
    }

    public static function toDetailsDto(Location $location, string $message = 'Location retrieved successfully.'): LocationDetailsResponseDTO
    {
        return new LocationDetailsResponseDTO(
            success: true,
            message: $message,
            id: $location->getId(),
            name: $location->getName(),
            type: $location->getType(),
            description: $location->getDescription(),
            address: $location->getAddress(),
            floor: $location->getFloor(),
            latitude: $location->getLatitude(),
            longitude: $location->getLongitude(),
            manager: $location->getManager(),
            emergencyContact: $location->getEmergencyContact(),
            emergencyPhone: $location->getEmergencyPhone(),
            accessRequirements: $location->getAccessRequirements(),
            operatingHours: $location->getOperatingHours(),
            notes: $location->getNotes(),
            isActive: $location->isActive(),
            zones: $location->getZones(),
            systems: $location->getSystems(),
            machines: $location->getMachines(),
            workOrders: $location->getWorkOrders(),
            createdBy: $location->getCreatedBy(),
            updatedBy: $location->getUpdatedBy(),
            createdAt: $location->getCreatedAt(),
            updatedAt: $location->getUpdatedAt()
        );
    }

    /**
     * @param Location[] $locations
     */
    public static function toCollectionDto(array $locations): AllLocationsResponseDTO
    {
        $dtos = array_map(
            fn(Location $location) => self::toDto($location),
            $locations
        );

        return new AllLocationsResponseDTO(
            success: true,
            message: 'Locations retrieved successfully.',
            locations: $dtos
        );
    }
}
