<?php

namespace Src\User\Application\Mappers;

use Src\User\Application\DTOs\AllUsersResponseDTO;
use Src\User\Application\DTOs\UserDetailsResponseDTO;
use Src\User\Application\DTOs\UserResponseDTO;
use Src\User\Domain\Entity\User;

class UserMapper
{
    public static function toDto(User $user, string $message = 'User retrieved successfully.'): UserResponseDTO
    {
        return new UserResponseDTO(
            success: true,
            message: $message,
            id: $user->getId(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            email: $user->getEmail()->value(),
            role: $user->getRole(),
            phone: $user->getPhone(),
            department: $user->getDepartment(),
            avatarUrl: $user->getAvatarUrl(),
            isActive: $user->isActive(),
            lastLogin: $user->getLastLogin(),
            workOrders: $user->getWorkOrders()
        );
    }

    public static function toDetailsDto(User $user, string $message = 'User retrieved successfully.'): UserDetailsResponseDTO
    {
        return new UserDetailsResponseDto(
            success: true,
            message: $message,
            id: $user->getId(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            email: $user->getEmail()->value(),
            role: $user->getRole(),
            phone: $user->getPhone(),
            department: $user->getDepartment(),
            notes: $user->getNotes(),
            avatarUrl: $user->getAvatarUrl(),
            isActive: $user->isActive(),
            lastLogin: $user->getLastLogin(),
            workOrders: $user->getWorkOrders(),
            createdBy: $user->getCreatedBy(),
            updatedBy: $user->getUpdatedBy(),
            createdAt: $user->getCreatedAt(),
            updatedAt: $user->getUpdatedAt(),
        );
    }

    /**
     * @param User[] $users
     */
    public static function toDtoCollection(array $users): AllUsersResponseDTO
    {
        $dtos = array_map(fn(User $user) => self::toDto($user), $users);

        return new AllUsersResponseDTO(
            success: true,
            message: 'Users retrieved successfully.',
            users: $dtos
        );
    }
}
