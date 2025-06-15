<?php

namespace Src\Role\Domain\Repositories;

use Src\Role\Domain\Entities\Permission;
use Src\Role\Domain\Entities\PermissionEntity;

interface PermissionRepositoryInterface
{
    /**
     * @return Permission[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Permission;

    public function findByName(string $name): ?Permission;
}
