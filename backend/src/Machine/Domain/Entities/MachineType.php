<?php

namespace Src\Machine\Domain\Entities;

use Src\Machine\Domain\ValueObject\MachineTypeCreatedAt;
use Src\Machine\Domain\ValueObject\MachineTypeUpdatedAt;
use Src\User\Domain\Entity\User;

interface MachineType
{
    public function getId(): int;
    public function getName(): string;
    public function getCreatedBy(): ?User;
    public function getUpdatedBy(): ?User;
    public function getCreatedAt(): MachineTypeCreatedAt;
    public function getUpdatedAt(): MachineTypeUpdatedAt;

    public function changeName(string $name): self;
    public function changeUpdatedBy(?User $user): self;
    public function changeUpdatedAt(MachineTypeUpdatedAt $updatedAt): self;

    public function isPersisted(): bool;
}
