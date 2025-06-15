<?php

namespace Src\Location\Domain\Entity;

use Src\Location\Domain\ValueObject\LocationSystemCreatedAt;
use Src\Location\Domain\ValueObject\LocationSystemType;
use Src\User\Domain\Entity\User;

interface LocationSystem
{
    public function getId(): int;

    public function getSystemType(): LocationSystemType;

    public function getLocationId(): int;
}
