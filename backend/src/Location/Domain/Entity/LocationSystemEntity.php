<?php

namespace Src\Location\Domain\Entity;

use Src\Location\Domain\ValueObject\LocationSystemCreatedAt;
use Src\Location\Domain\ValueObject\LocationSystemType;
use Src\User\Domain\Entity\User;

class LocationSystemEntity implements LocationSystem
{
    public function __construct(
        private int $id,
        private LocationSystemType $systemType,
        private int $locationId,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getSystemType(): LocationSystemType
    {
        return $this->systemType;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }
}
