<?php

namespace Src\Role\Application\Mappers;

use Src\Role\Application\DTOs\AllRolesResponseDTO;
use Src\Role\Application\DTOs\RoleDetailsResponseDTO;
use Src\Role\Application\DTOs\RoleResponseDTO;
use Src\Role\Domain\Entities\Role;

class RoleMapper
{
    public static function toDto(Role $role, string $message = 'Role retrieved successfully.')
    {
        return new RoleResponseDTO(
            success: true,
            message: $message,
            id: $role->getId(),
            name: $role->getName(),
            description: $role->getDescription(),
            color: $role->getColor(),
            isActive: $role->isActive(),
            permissions: $role->getPermissions(),
            users: $role->getUsers(),
            createdAt: $role->getCreatedAt(),
            updatedAt: $role->getUpdatedAt(),
        );
    }

    public static function toDetailsDto(Role $role, string $message = 'Role retrieved successfully.'): RoleDetailsResponseDTO
    {
        return new RoleDetailsResponseDTO(
            success: true,
            message: $message,
            id: $role->getId(),
            name: $role->getName(),
            description: $role->getDescription(),
            color: $role->getColor(),
            isActive: $role->isActive(),
            permissions: $role->getPermissions(),
            users: $role->getUsers(),
            createdBy: $role->getCreatedBy(),
            updatedBy: $role->getUpdatedBy(),
            createdAt: $role->getCreatedAt(),
            updatedAt: $role->getUpdatedAt(),
        );
    }

    /**
     * @param Role[] $roles
     */
    public static function toDtoCollection(array $roles, string $message = 'Roles retrieved successfully.'): AllRolesResponseDTO
    {
        $dtos = array_map(
            fn(Role $role) => self::toDto($role),
            $roles
        );

        return new AllRolesResponseDTO(
            success: true,
            message: $message,
            roles: $dtos
        );
    }
}
