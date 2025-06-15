<?php

namespace Src\Auth\Application\DTOs;

class LoginRequestDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}