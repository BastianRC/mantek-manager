<?php

namespace Src\Machine\Application\DTOs;

class CreateMachineCategoryRequestDTO
{
    public function __construct(
        public string $name,
        public ?int $createdById
    ) {}
}
