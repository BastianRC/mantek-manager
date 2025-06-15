<?php

namespace Src\Machine\Domain\Entities;

use Src\Machine\Domain\ValueObject\MachineCategoryCreatedAt;
use Src\Machine\Domain\ValueObject\MachineCategoryUpdatedAt;
use Src\User\Domain\Entity\User;

interface MachineCategory
{
    public function getId(): int;
    public function getName(): string;
    public function getCreatedBy(): ?User;
    public function getUpdatedBy(): ?User;
    public function getCreatedAt(): MachineCategoryCreatedAt;
    public function getUpdatedAt(): MachineCategoryUpdatedAt;

    public function changeName(string $name): self;
    public function changeUpdatedBy(?User $user): self;
    public function changeUpdatedAt(MachineCategoryUpdatedAt $updatedAt): self;

    public function isPersisted(): bool;
}
