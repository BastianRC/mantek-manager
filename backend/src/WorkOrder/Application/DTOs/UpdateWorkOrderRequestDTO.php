<?php

namespace Src\WorkOrder\Application\DTOs;

class UpdateWorkOrderRequestDTO
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $title,
        public readonly ?string $type,
        public readonly ?string $description,
        public readonly ?string $priority,
        public readonly ?string $status,
        public readonly ?string $dueAt,
        public readonly ?string $pausedAt,
        public readonly ?string $startedAt,
        public readonly ?string $completedAt,
        public readonly ?float $estimatedHours,
        public readonly ?int $locationId,
        public readonly ?int $machineId,
        public readonly ?int $assigneeId,
        public readonly ?string $requestedBy,
        public readonly ?string $approvedBy,
        public readonly ?string $notes,
        public readonly ?array $materials,
        public readonly int $updatedById
    ) {}
}
