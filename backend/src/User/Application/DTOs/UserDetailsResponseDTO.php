<?php

namespace Src\User\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserLastLogin;
use Src\User\Domain\ValueObject\UserUpdatedAt;

class UserDetailsResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $role,
        public string $phone,
        public string $department,
        public ?string $notes,
        public ?string $avatarUrl,
        public bool $isActive,
        public ?UserLastLogin $lastLogin,
        public ?User $createdBy,
        public ?User $updatedBy,
        public UserCreatedAt $createdAt,
        public UserUpdatedAt $updatedAt
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
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'role' => $this->role,
                'phone' => $this->phone,
                'department' => $this->department,
                'notes' => $this->notes,
                'avatar_url' => $this->avatarUrl,
                'is_active' => $this->isActive,
                'last_login' => $this->lastLogin ? $this->lastLogin->toString() : null,
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
