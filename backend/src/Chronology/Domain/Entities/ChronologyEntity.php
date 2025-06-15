<?php

namespace Src\Chronology\Domain\Entities;

use Src\Chronology\Domain\ValueObject\ChronologyCreatedAt;
use Src\Chronology\Domain\ValueObject\ChronologyEventType;
use Src\Chronology\Domain\ValueObject\ChronologyMeta;
use Src\Chronology\Domain\ValueObject\ChronologyTargetType;

use Src\User\Domain\Entity\User;

class ChronologyEntity implements Chronology
{
    public function __construct(
        private int $id,
        private ?User $user,
        private ChronologyTargetType $targetType,
        private int $targetId,
        private ChronologyEventType $eventType,
        private ?string $description,
        private ?ChronologyMeta $meta,
        private ChronologyCreatedAt $createdAt
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getTargetType(): ChronologyTargetType
    {
        return $this->targetType;
    }

    public function getTargetId(): int
    {
        return $this->targetId;
    }

    public function getEventType(): ChronologyEventType
    {
        return $this->eventType;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getMeta(): ?ChronologyMeta
    {
        return $this->meta;
    }

    public function getCreatedAt(): ChronologyCreatedAt
    {
        return $this->createdAt;
    }
}
