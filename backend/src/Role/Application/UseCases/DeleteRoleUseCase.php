<?php

namespace Src\Role\Application\UseCases;

use Src\Role\Domain\Exceptions\CannotDeleteSuperAdminRoleException;
use Src\Role\Domain\Exceptions\RoleNotFoundException;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;

class DeleteRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $repo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(int $id): BaseResponseDto
    {
        $role = $this->repo->findById($id);
        throw_if(!$role, RoleNotFoundException::class);

        $this->repo->delete($role);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'role',
            targetId: $role->getId(),
            eventType: 'deleted',
            description: 'Rol eliminado',
            meta: []
        );

        return ResponseMapper::toDto('Role deleted succesfully.');
    }
}
