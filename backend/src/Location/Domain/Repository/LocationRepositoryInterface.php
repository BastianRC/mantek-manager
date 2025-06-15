<?php

namespace Src\Location\Domain\Repository;

use Src\Location\Domain\Entity\Location;

interface LocationRepositoryInterface
{
    /**
     * @return Location[]
     */
    public function findAll(): array;
    public function findById(int $id): ?Location;
    public function create(Location $location): Location;
    public function update(Location $location): Location;
    public function delete(Location $location): void;
}
