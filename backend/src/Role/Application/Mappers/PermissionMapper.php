<?php

namespace Src\Role\Application\Mappers;

use Src\Role\Application\DTOs\AllPermissionsResponseDTO;
use Src\Role\Domain\Entities\Permission;

class PermissionMapper
{
    /**
     * @param Permission[] $permissions
     */
    public static function toDtoCollection(array $permissions, string $message = 'Permissions retrieved successfully.'): AllPermissionsResponseDTO
    {
        $dtos = array_map(
            fn(Permission $p) => [
                'id' => $p->getId(),
                'name' => $p->getName()
            ],
            $permissions
        );

        return new AllPermissionsResponseDTO(
            success: true,
            message: $message,
            permissions: $dtos
        );
    }
}
