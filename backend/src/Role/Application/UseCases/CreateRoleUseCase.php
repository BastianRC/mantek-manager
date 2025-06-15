<?php

namespace Src\Role\Application\UseCases;

use Src\Role\Application\DTOs\CreateRoleRequestDTO;
use Src\Role\Application\DTOs\RoleDetailsResponseDTO;
use Src\Role\Application\DTOs\RoleResponseDTO;
use Src\Role\Application\Mappers\RoleMapper;
use Src\Role\Domain\Entities\RoleEntity;
use Src\Role\Domain\Exceptions\RoleAlreadyExistsException;
use Src\Role\Domain\Repositories\PermissionRepositoryInterface;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;
use Src\Role\Domain\ValueObject\RoleCreatedAt;
use Src\Role\Domain\ValueObject\RoleUpdatedAt;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class CreateRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $roleRepo,
        private readonly PermissionRepositoryInterface $permissionRepo,
        private readonly UserRepositoryInterface $userRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(CreateRoleRequestDTO $dto): RoleDetailsResponseDTO
    {
        $existing = $this->roleRepo->findByName($dto->name);
        throw_if($existing, RoleAlreadyExistsException::class);

        $createdBy = $this->userRepo->findById($dto->createdBy);
        throw_if(!$createdBy, UserNotFoundException::class);

        $permissions = array_values(array_filter(
            array_map(
                fn(string $name) => $this->permissionRepo->findByName($name),
                $dto->permissions
            )
        ));

        $role = new RoleEntity(
            id: 0,
            name: $dto->name,
            description: $dto->description,
            color: $dto->color,
            isActive: $dto->isActive,
            permissions: $permissions,
            users: [],
            createdAt: new RoleCreatedAt(),
            updatedAt: new RoleUpdatedAt(),
            createdBy: $createdBy,
            updatedBy: null,
        );

        $created = $this->roleRepo->create($role);

        $this->chronologyLogger->log(
            user: $createdBy,
            targetType: 'role',
            targetId: $created->getId(),
            eventType: 'created',
            description: 'Rol creado',
            meta: [
                'name' => $created->getName(),
                'color' => $created->getColor(),
            ]
        );

        return RoleMapper::toDetailsDto($created, 'Role created succesfully.');
    }
}
