<?php

namespace Src\Machine\Domain\Entities;

use Src\Machine\Domain\ValueObject\MachineTypeCreatedAt;
use Src\Machine\Domain\ValueObject\MachineTypeUpdatedAt;

use Src\User\Domain\Entity\User;

class MachineTypeEntity implements MachineType
{
    public function __construct(
        private int $id,
        private string $name,
        private ?User $createdBy,
        private ?User $updatedBy,
        private MachineTypeCreatedAt $createdAt,
        private MachineTypeUpdatedAt $updatedAt
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }
    public function getCreatedAt(): MachineTypeCreatedAt
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): MachineTypeUpdatedAt
    {
        return $this->updatedAt;
    }

    public function changeName(string $name): self
    {
        return $this->withClone(fn(self $c) => $c->name = $name);
    }

    public function changeUpdatedBy(?User $user): self
    {
        return $this->withClone(fn(self $c) => $c->updatedBy = $user);
    }

    public function changeUpdatedAt(MachineTypeUpdatedAt $updatedAt): self
    {
        return $this->withClone(fn(self $c) => $c->updatedAt = $updatedAt);
    }

    public function isPersisted(): bool
    {
        return $this->id > 0;
    }

    private function withClone(\Closure $callback): self
    {
        $clone = clone $this;
        $callback($clone);
        return $clone;
    }
}
