<?php

namespace Src\Role\Application\DTOs;

use Src\Role\Domain\ValueObject\RolePermission;

class CreateRoleRequestDTO
{
    /**
     * @param string[] $permissions
     */
    public function __construct(
        public string $name,
        public string $description,
        public string $color = 'blue',
        public bool $isActive = true,

        /** @var string[] */
        public array $permissions = [],
        public ?int $createdBy,
    ) {}
}
