<?php

namespace Src\WorkOrder\Domain\Entities;

final class WorkOrderRelationEntity
{
    public function __construct(
        public int $id,
        public string $orderNumber,
        public string $name,
        public string $status,
        public string $type,
        public string $asigneeName,
        public string $createdAt,
        public string $dueAt,
    ) {}
}
