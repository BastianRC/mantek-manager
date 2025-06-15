<?php

namespace Src\Role\Application\UseCases;

use Src\Role\Application\DTOs\AllPermissionsResponseDTO;
use Src\Role\Application\Mappers\PermissionMapper;
use Src\Role\Domain\Repositories\PermissionRepositoryInterface;

class GetPermissionsListUseCase
{
    public function __construct(
        private PermissionRepositoryInterface $repo
    ) {}

    public function execute(): AllPermissionsResponseDTO
    {
        $permissions = $this->repo->findAll();
        
        return PermissionMapper::toDtoCollection($permissions);
    }
}
