<?php

namespace Src\Role\Domain\Entities;

use Src\Role\Domain\ValueObject\RoleCreatedAt;
use Src\Role\Domain\ValueObject\RolePermission;
use Src\Role\Domain\ValueObject\RoleUpdatedAt;
use Src\User\Domain\Entity\User;

interface Role
{
    public function getId(): int;
    public function getName(): string;
    public function getDescription(): string;
    public function getColor(): string;
    public function isActive(): bool;
    public function isPersisted(): bool;
    /**
     *
     * @return User[]
     */
    public function getUsers(): array;
    public function getUsersCount(): int;
    public function getCreatedAt(): RoleCreatedAt;
    public function getUpdatedAt(): RoleUpdatedAt;
    public function getCreatedBy(): ?User;
    public function getUpdatedBy(): ?User;
    /**
     * @return Permission[]
     */
    public function getPermissions(): array;
    public function changeName(string $name): self;
    public function changeDescription(string $description): self;
    public function changeColor(string $color): self;
    public function activate(): self;
    public function desactivate(): self;
    public function changeUpdatedBy(?User $updatedBy): self;
    public function changeUpdatedAt(RoleUpdatedAt $updatedAt): self;
    /**
     * @param Permission[] $permissions
     */
    public function assignPermissions(array $permissions): self;
}
