<?php

namespace Src\User\Application\DTOs;

class UpdateUserRequestDTO
{
    public function __construct(
        public int $id,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $password = null,
        public ?string $department = null,
        public ?string $notes = null,
        public ?string $avatarUrl = null,
        public ?bool $isActive = null,
        public ?int $updatedBy = null,
        public ?string $role = null,
    ) {}
}
