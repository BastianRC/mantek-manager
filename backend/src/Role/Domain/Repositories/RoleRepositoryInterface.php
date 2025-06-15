<?php

namespace Src\Role\Domain\Repositories;

use Src\Role\Domain\Entities\Role;

interface RoleRepositoryInterface
{
    /**
     * @return Role[]
     */
    public function findAll(): array;
    public function findById(int $id): ?Role;
    public function findByName(string $name): ?Role;
    public function create(Role $role): Role;
    public function update(Role $role): Role;
    public function delete(Role $role): void;

    /**
     * Asigna permisos al rol
     * @param int $roleId
     * @param string[] $permissions
     */
    public function syncPermissions(Role $role, array $permissions): void;
}
