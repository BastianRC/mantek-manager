<?php

namespace Src\User\Application\DTOs;

class CreateUserRequestDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $phone,
        public string $password,
        public string $department,
        public ?string $notes,
        public ?string $avatarUrl,
        public ?bool $isActive,
        public ?int $createdBy,
        public string $role
    ) {}
}
