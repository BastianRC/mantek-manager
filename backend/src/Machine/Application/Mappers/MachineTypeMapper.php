<?php

namespace Src\Machine\Application\Mappers;

use Src\Machine\Application\DTOs\AllMachineTypesResponseDTO;
use Src\Machine\Application\DTOs\MachineTypeResponseDTO;
use Src\Machine\Domain\Entities\MachineType;

class MachineTypeMapper
{
    public static function toDto(MachineType $type, string $message = 'Machine type retrieved successfully.'): MachineTypeResponseDTO
    {
        return new MachineTypeResponseDTO(
            success: true,
            message: $message,
            id: $type->getId(),
            name: $type->getName(),
            createdAt: $type->getCreatedAt(),
            updatedAt: $type->getUpdatedAt()
        );
    }

    /**
     * @param MachineType[] $types
     */
    public static function toCollectionDto(array $types): AllMachineTypesResponseDTO
    {
        $dtos = array_map(
            fn(MachineType $type) => self::toDto($type),
            $types
        );

        return new AllMachineTypesResponseDTO(
            success: true,
            message: 'Machine types retrieved successfully.',
            types: $dtos
        );
    }
}
