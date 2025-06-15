<?php

namespace Src\Location\Domain\Repository;

use Src\Location\Domain\Entity\LocationSystem;

interface LocationSystemRepositoryInterface
{
    /**
     * @return LocationSystem[]
     */
    public function findAllByLocationId(int $locationId): array;

    public function findById(int $id): ?LocationSystem;

    public function assign(LocationSystem $system): LocationSystem;
}
