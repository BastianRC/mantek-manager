<?php

namespace Src\Chronology\Application\DTOs;

class CreateChronologyRequestDTO
{
    public function __construct(
        public ?int $userId,
        public string $targetType,
        public int $targetId,
        public string $eventType,
        public ?string $description = null,
        public ?array $meta = null
    ) {}
}
