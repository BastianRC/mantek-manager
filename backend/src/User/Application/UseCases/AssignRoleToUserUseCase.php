<?php

namespace Src\User\Application\UseCases;

use Src\Role\Domain\Exceptions\RoleNotFoundException;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;
use Src\User\Application\DTOs\AssignRoleToUserRequestDTO;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class AssignRoleToUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repo,
        private RoleRepositoryInterface $roleRepo,
    ) {}

    public function execute(AssignRoleToUserRequestDTO $dto): BaseResponseDto
    {
        $user = $this->repo->findById($dto->userId);

        throw_if(!$user, UserNotFoundException::class);

        /* $role = $this->roleRepo->findByName($dto->roleName);
        throw_if(!$role, RoleNotFoundException::class); */

        $this->repo->assignRole($user, $dto->role);

        return ResponseMapper::toDto('Role assigned successfully.');
    }
}
