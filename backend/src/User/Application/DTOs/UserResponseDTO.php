<?php

namespace Src\User\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\ValueObject\UserLastLogin;

class UserResponseDTO extends BaseResponseDto
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
        public ?string $avatarUrl,
        public bool $isActive,
        public ?UserLastLogin $lastLogin
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
                'avatar_url' => $this->avatarUrl,
                'is_active' => $this->isActive,
                'last_login' => $this->lastLogin?->toString()
            ]
        ];
    }
}
