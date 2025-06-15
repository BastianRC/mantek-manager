<?php

namespace Src\User\Application\DTOs;

class AssignRoleToUserRequestDTO
{
    public function __construct(
        public int $userId,
        public string $role
    ) {}
}
