<?php

namespace Src\Machine\Application\DTOs;

class CreateMachineTypeRequestDTO
{
    public function __construct(
        public string $name,
        public ?int $createdById
    ) {}
}
