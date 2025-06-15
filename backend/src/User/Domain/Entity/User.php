<?php

namespace Src\User\Domain\Entity;

use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserLastLogin;
use Src\User\Domain\ValueObject\UserUpdatedAt;

interface User
{
    public function getId(): int;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getFullName(): string;
    public function getEmail(): UserEmail;
    public function getRole(): string;
    public function getPhone(): string;
    public function getPassword(): HashedUserPassword;
    public function getDepartment(): string;
    public function getNotes(): ?string;
    public function getAvatarUrl(): ?string;
    public function isActive(): bool;
    public function getLastLogin(): ?UserLastLogin;
    public function getCreatedAt(): UserCreatedAt;
    public function getUpdatedAt(): UserUpdatedAt;
    public function getCreatedBy(): ?self;
    public function getUpdatedBy(): ?self;

    public function isPersisted(): bool;

    public function changeFirstName(string $firstName): self;
    public function changeLastName(string $lastName): self;
    public function changeEmail(UserEmail $email): self;
    public function changePhone(string $phone): self;
    public function changeDepartment(string $department): self;
    public function changeNotes(?string $notes): self;
    public function changeAvatarUrl(?string $avatarUrl): self;
    public function changeIsActive(bool $active): self;
    public function changeLastLogin(?UserLastLogin $lastLogin): self;
    public function changePassword(HashedUserPassword $password): self;
    public function changeUpdatedBy(?self $updatedBy): self;
    public function changeUpdatedAt(UserUpdatedAt $updatedAt): self;
}
