<?php

namespace Src\Machine\Domain\Entities;

final class MachineRelationEntity
{
    public function __construct(
        public int $id,
        public string $name,
        public string $locationName,
        public string $type,
        public string $status,
    ) {}
}
