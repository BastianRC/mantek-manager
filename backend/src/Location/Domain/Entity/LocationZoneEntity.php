<?php

namespace Src\Location\Domain\Entity;

use Src\Location\Domain\ValueObject\LocationZoneCreatedAt;
use Src\User\Domain\Entity\User;

class LocationZoneEntity implements LocationZone
{
    public function __construct(
        private int $id,
        private string $zoneName,
        private int $locationId,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getZoneName(): string
    {
        return $this->zoneName;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }
}
