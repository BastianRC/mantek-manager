<?php

namespace Src\Role\Domain\Entities;

use Src\Role\Domain\ValueObject\RoleCreatedAt;
use Src\Role\Domain\ValueObject\RoleUpdatedAt;
use Src\User\Domain\Entity\User;

class RoleEntity implements Role
{
    /**
     * @param Permission[] $permissions
     */
    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private string $color,
        private bool $isActive,
        private array $permissions,
        private array $users,
        private RoleCreatedAt $createdAt,
        private RoleUpdatedAt $updatedAt,
        private ?User $createdBy,
        private ?User $updatedBy
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getColor(): string
    {
        return $this->color;
    }
    public function isActive(): bool
    {
        return $this->isActive;
    }
    public function isPersisted(): bool
    {
        return $this->id > 0;
    }
    public function getUsers(): array
    {
        return $this->users;
    }
    public function getUsersCount(): int
    {
        return count($this->users);
    }
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }
    public function getCreatedAt(): RoleCreatedAt
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): RoleUpdatedAt
    {
        return $this->updatedAt;
    }

    /**
     * @param Permission[] $permissions
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function changeName(string $name): self
    {
        return $this->withClone(fn($c) => $c->name = $name);
    }

    public function changeDescription(string $description): self
    {
        return $this->withClone(fn($c) => $c->description = $description);
    }

    public function changeColor(string $color): self
    {
        return $this->withClone(fn($c) => $c->color = $color);
    }

    public function activate(): self
    {
        return $this->withClone(fn($c) => $c->isActive = true);
    }

    public function desactivate(): self
    {
        return $this->withClone(fn($c) => $c->isActive = false);
    }

    public function changeUpdatedBy(?User $updatedBy): self
    {
        return $this->withClone(fn($c) => $c->updatedBy = $updatedBy);
    }

    public function changeUpdatedAt(RoleUpdatedAt $updatedAt): self
    {
        return $this->withClone(fn($c) => $c->updatedAt = $updatedAt);
    }

    public function assignPermissions(array $permissions): self
    {
        return $this->withClone(fn($c) => $c->permissions = $permissions);
    }

    private function withClone(\Closure $callback): self
    {
        $clone = clone $this;
        $callback($clone);
        return $clone;
    }
}
