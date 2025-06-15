<?php

namespace Src\Chronology\Domain\Entities;

use Src\Chronology\Domain\ValueObject\ChronologyCreatedAt;
use Src\Chronology\Domain\ValueObject\ChronologyEventType;
use Src\Chronology\Domain\ValueObject\ChronologyMeta;
use Src\Chronology\Domain\ValueObject\ChronologyTargetType;

use Src\User\Domain\Entity\User;

interface Chronology
{
    public function getId(): int;
    public function getUser(): ?User;
    public function getTargetType(): ChronologyTargetType;
    public function getTargetId(): int;
    public function getEventType(): ChronologyEventType;
    public function getDescription(): ?string;
    public function getMeta(): ?ChronologyMeta;
    public function getCreatedAt(): ChronologyCreatedAt;
}
