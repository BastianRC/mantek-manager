<?php

namespace Src\Role\Application\UseCases;

use Src\Role\Application\DTOs\RoleResponseDTO;
use Src\Role\Application\DTOs\UpdateRoleRequestDTO;
use Src\Role\Application\Mappers\PermissionMapper;
use Src\Role\Application\Mappers\RoleMapper;
use Src\Role\Domain\Exceptions\RoleNotFoundException;
use Src\Role\Domain\Repositories\PermissionRepositoryInterface;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;
use Src\Role\Domain\ValueObject\RoleUpdatedAt;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class UpdateRoleUseCase
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepo,
        private readonly PermissionRepositoryInterface $permissionRepo,
        private readonly UserRepositoryInterface $userRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(UpdateRoleRequestDTO $dto): RoleResponseDTO
    {
        $role = $this->roleRepo->findById($dto->id);
        throw_if(!$role, RoleNotFoundException::class);

        $updatedRole = $role;

        $map = [
            'name'          => fn($r, $v) => $r->changeName($v),
            'description'   => fn($r, $v) => $r->changeDescription($v),
            'color'         => fn($r, $v) => $r->changeColor($v),
            'isActive'      => fn($r, $v) => $v ? $r->activate() : $r->desactivate(),
            'permissions'   => fn($r, $v) => $r->assignPermissions(
                array_values(array_filter(
                    array_map(
                        fn(string $name) => $this->permissionRepo->findByName($name),
                        $v
                    )
                ))
            ),
            'updatedBy'     => fn($r, $v) => $r->changeUpdatedBy($this->userRepo->findById($v)),
        ];

        foreach ($map as $key => $callback) {
            if (!is_null($dto->$key)) {
                $updatedRole = $callback($updatedRole, $dto->$key);
            }
        }

        $updatedRole = $updatedRole->changeUpdatedAt(new RoleUpdatedAt());

        $updated = $this->roleRepo->update($updatedRole);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'role',
            targetId: $role->getId(),
            eventType: 'updated',
            description: 'Usuario actualizado',
            meta: [
                'name' => $role->getName(),
                'color' => $role->getColor(),
            ]
        );

        return RoleMapper::toDto($updated, 'Role updated succuesfully.');
    }
}
