<?php

namespace Src\Role\Application\UseCases;

use Src\Role\Application\DTOs\AllRolesResponseDto;
use Src\Role\Application\Mappers\RoleMapper;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;

class GetRolesListUseCase
{
    public function __construct(
        private RoleRepositoryInterface $repo
    ) {}

    public function execute(): AllRolesResponseDto
    {
        $roles = $this->repo->findAll();
        
        return RoleMapper::toDtoCollection($roles);
    }
}
