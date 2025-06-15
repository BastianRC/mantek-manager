<?php

namespace Src\Location\Domain\Entity;

use Src\Location\Domain\ValueObject\LocationZoneCreatedAt;
use Src\User\Domain\Entity\User;

interface LocationZone
{
    public function getId(): int;
    public function getZoneName(): string;
    public function getLocationId(): int;
}
