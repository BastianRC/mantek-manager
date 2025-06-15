<?php

namespace Src\Location\Application\DTOs;

class CreateLocationRequestDTO
{
    public function __construct(
        public string $name,
        public string $type,
        public string $description,
        public string $address,
        public ?int $floor,
        public ?float $latitude,
        public ?float $longitude,
        public ?int $managerId,
        public ?string $emergencyContact,
        public ?string $emergencyPhone,
        public ?string $accessRequirements,
        public ?string $operatingHours,
        public ?string $notes,
        public bool $isActive,
        public ?int $createdBy,

        public ?array $zones,
        public ?array $systems
    ) {}
}
