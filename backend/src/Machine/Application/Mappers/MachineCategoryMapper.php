<?php

namespace Src\Machine\Application\Mappers;

use Src\Machine\Application\DTOs\MachineCategoryResponseDTO;
use Src\Machine\Application\DTOs\AllMachineCategoriesResponseDTO;
use Src\Machine\Domain\Entities\MachineCategory;

class MachineCategoryMapper
{
    public static function toDto(MachineCategory $category, string $message = 'Machine category retrieved successfully.'): MachineCategoryResponseDTO
    {
        return new MachineCategoryResponseDTO(
            success: true,
            message: $message,
            id: $category->getId(),
            name: $category->getName(),
            createdAt: $category->getCreatedAt(),
            updatedAt: $category->getUpdatedAt()
        );
    }

    /**
     * @param MachineCategory[] $categories
     */
    public static function toCollectionDto(array $categories): AllMachineCategoriesResponseDTO
    {
        $dtos = array_map(
            fn(MachineCategory $category) => self::toDto($category),
            $categories
        );

        return new AllMachineCategoriesResponseDTO(
            success: true,
            message: 'Machine categories retrieved successfully.',
            categories: $dtos
        );
    }
}
