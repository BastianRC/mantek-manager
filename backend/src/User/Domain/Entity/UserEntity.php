<?php

namespace Src\User\Domain\Entity;

use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserLastLogin;
use Src\User\Domain\ValueObject\UserUpdatedAt;

class UserEntity implements User
{
    public function __construct(
        private int $id,
        private string $firstName,
        private string $lastName,
        private UserEmail $email,
        private string $role,
        private string $phone,
        private HashedUserPassword $password,
        private string $department,
        private ?string $notes,
        private ?string $avatarUrl,
        private bool $isActive,
        private ?UserLastLogin $lastLogin,
        private UserCreatedAt $createdAt,
        private UserUpdatedAt $updatedAt,
        private ?User $createdBy,
        private ?User $updatedBy,

        /** @var WorkOrder[] */
        private ?array $workOrders
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
    public function getEmail(): UserEmail
    {
        return $this->email;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getPhone(): string
    {
        return $this->phone;
    }
    public function getPassword(): HashedUserPassword
    {
        return $this->password;
    }
    public function getDepartment(): string
    {
        return $this->department;
    }
    public function getNotes(): ?string
    {
        return $this->notes;
    }
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }
    public function isActive(): bool
    {
        return $this->isActive;
    }
    public function getLastLogin(): ?UserLastLogin
    {
        return $this->lastLogin;
    }
    public function getCreatedAt(): UserCreatedAt
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): UserUpdatedAt
    {
        return $this->updatedAt;
    }
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function getWorkOrders(): ?array
    {
        return $this->workOrders;
    }

    public function isPersisted(): bool
    {
        return $this->id > 0;
    }

    public function changeFirstName(string $firstName): self
    {
        return $this->withClone(fn($c) => $c->firstName = $firstName);
    }

    public function changeLastName(string $lastName): self
    {
        return $this->withClone(fn($c) => $c->lastName = $lastName);
    }

    public function changeEmail(UserEmail $email): self
    {
        return $this->withClone(fn($c) => $c->email = $email);
    }
    public function changeRole(string $role): self
    {
        return $this->withClone(fn($c) => $c->role = $role);
    }

    public function changePhone(string $phone): self
    {
        return $this->withClone(fn($c) => $c->phone = $phone);
    }

    public function changeDepartment(string $department): self
    {
        return $this->withClone(fn($c) => $c->department = $department);
    }

    public function changeNotes(?string $notes): self
    {
        return $this->withClone(fn($c) => $c->notes = $notes);
    }

    public function changeAvatarUrl(?string $avatarUrl): self
    {
        return $this->withClone(fn($c) => $c->avatarUrl = $avatarUrl);
    }

    public function changeIsActive(bool $active): self
    {
        return $this->withClone(fn($c) => $c->isActive = $active);
    }

    public function changeLastLogin(?UserLastLogin $lastLogin): self
    {
        return $this->withClone(fn($c) => $c->lastLogin = $lastLogin);
    }
    public function changePassword(HashedUserPassword $password): self
    {
        return $this->withClone(fn($c) => $c->password = $password);
    }

    public function changeUpdatedBy(?User $updatedBy): self
    {
        return $this->withClone(fn($c) => $c->updatedBy = $updatedBy);
    }

    public function changeUpdatedAt(UserUpdatedAt $updatedAt): self
    {
        return $this->withClone(fn($c) => $c->updatedAt = $updatedAt);
    }

    private function withClone(\Closure $callback): self
    {
        $clone = clone $this;
        $callback($clone);
        return $clone;
    }
}
