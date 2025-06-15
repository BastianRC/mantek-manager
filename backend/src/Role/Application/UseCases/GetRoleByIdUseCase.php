<?php

namespace Src\Role\Application\UseCases;

use Src\Role\Application\DTOs\RoleDetailsResponseDTO;
use Src\Role\Application\DTOs\RoleResponseDTO;
use Src\Role\Application\Mappers\RoleMapper;
use Src\Role\Domain\Exceptions\RoleNotFoundException;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;

class GetRoleByIdUseCase
{
    public function __construct(
        private RoleRepositoryInterface $repo
    ) {}

    public function execute(int $id): RoleDetailsResponseDTO
    {
        $role = $this->repo->findById($id);

        throw_if(!$role, RoleNotFoundException::class);

        return RoleMapper::toDetailsDto($role, 'Role retrieved successfully.');
    }
}
