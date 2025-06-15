<?php

namespace Src\Machine\Application\DTOs;

class UpdateMachineCategoryRequestDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?int $updatedById
    ) {}
}
