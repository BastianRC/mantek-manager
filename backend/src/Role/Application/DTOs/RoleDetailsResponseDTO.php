<?php

namespace Src\Role\Application\DTOs;

use Src\Role\Domain\Entities\Permission;
use Src\Role\Domain\ValueObject\RoleCreatedAt;
use Src\Role\Domain\ValueObject\RoleUpdatedAt;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;

class RoleDetailsResponseDTO extends BaseResponseDto
{
    /**
     * 
     * @param Permission[] $permissions
     */
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $name,
        public string $description,
        public string $color,
        public bool $isActive,
        public array $permissions,
        public array $users,
        public ?User $createdBy,
        public ?User $updatedBy,
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
                'users' => array_map(fn($u) => [
                    'id' => $u->getId(),
                    'first_name' => $u->getFirstName(),
                    'last_name' => $u->getLastName(),
                    'email' => $u->getEmail()->value(),
                    'department' => $u->getDepartment(),
                    'avatar_url' => $u->getAvatarUrl()
                ], $this->users),
                'created_by' => $this->createdBy ? [
                    'id' => $this->createdBy->getId(),
                    'name' => $this->createdBy->getFullName(),
                ] : null,
                'updated_by' => $this->updatedBy ? [
                    'id' => $this->updatedBy->getId(),
                    'name' => $this->updatedBy->getFullName(),
                ] : null,
                'created_at' => $this->createdAt->toString(),
                'updated_at' => $this->updatedAt->toString()
            ]
        ];
    }
}
