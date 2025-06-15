<?php

namespace Src\Machine\Application\DTOs;

class UpdateMachineTypeRequestDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?int $updatedById
    ) {}
}
