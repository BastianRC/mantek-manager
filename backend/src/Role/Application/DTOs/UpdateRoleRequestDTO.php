<?php

namespace Src\Role\Application\DTOs;

use Src\Role\Domain\ValueObject\RolePermission;

class UpdateRoleRequestDTO
{
    /**
     * @param string[]|null $permissions
     */
    public function __construct(
        public int $id,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $color = null,
        public ?bool $isActive = null,

        /** @var string[]|null */
        public ?array $permissions = null,
        public ?int $updatedBy = null,
    ) {}
}
