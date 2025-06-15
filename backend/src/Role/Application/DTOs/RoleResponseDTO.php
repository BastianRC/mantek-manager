<?php

namespace Src\Role\Application\DTOs;

use Src\Role\Domain\Entities\Permission;
use Src\Role\Domain\ValueObject\RoleCreatedAt;
use Src\Role\Domain\ValueObject\RoleUpdatedAt;
use Src\Shared\Application\DTOs\BaseResponseDto;

class RoleResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $name,
        public string $description,
        public string $color,
        public bool $isActive,
        public array $permissions,
        public int $usersCount,
        public RoleCreatedAt $createdAt,
        public RoleUpdatedAt $updatedAt
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'color' => $this->color,
                'is_active' => $this->isActive,
                'permissions' => array_map(
                    fn(Permission $p) => [
                        'id' => $p->getId(),
                        'name' => $p->getName()
                    ],
                    $this->permissions
                ),
                'users_count' => $this->usersCount,
                'created_at' => $this->createdAt->toString(),
                'updated_at' => $this->updatedAt->toString()
            ]
        ];
    }
}
