<?php

namespace Src\Role\Application\UseCases;

use Src\Role\Application\DTOs\AllRolesResponseDTO;
use Src\Role\Application\Mappers\RoleMapper;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;

class GetRolesListUseCase
{
    public function __construct(
        private RoleRepositoryInterface $repo
    ) {}

    public function execute(): AllRolesResponseDTO
    {
        $roles = $this->repo->findAll();
        
        return RoleMapper::toDtoCollection($roles);
    }
}
