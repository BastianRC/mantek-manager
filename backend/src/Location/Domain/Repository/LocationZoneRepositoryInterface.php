<?php

namespace Src\Location\Domain\Repository;

use Src\Location\Domain\Entity\LocationZone;

interface LocationZoneRepositoryInterface
{
    /**
     * @return LocationZone[]
     */
    public function findAllByLocationId(int $locationId): array;
    public function findById(int $id): ?LocationZone;
    public function create(LocationZone $zone): LocationZone;
    public function delete(LocationZone $zone): void;
}
