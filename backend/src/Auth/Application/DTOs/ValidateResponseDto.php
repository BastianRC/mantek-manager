<?php

namespace Src\Auth\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class ValidateResponseDto extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $email,
        public string $name,
        public string $role,
        public array $permissions
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
                'email' => $this->email,
                'name' => $this->name,
                'role' => $this->role,
                'permissions' => $this->permissions
            ],
        ];
    }
}
