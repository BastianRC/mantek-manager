<?php

namespace Src\User\Application\UseCases;

use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Application\DTOs\CreateUserRequestDTO;
use Src\User\Application\DTOs\UserResponseDTO;
use Src\User\Application\Mappers\UserMapper;
use Src\User\Domain\Entity\UserEntity;
use Src\User\Domain\Exceptions\UserAlreadyExistsException;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserUpdatedAt;

class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(CreateUserRequestDTO $dto): UserResponseDTO
    {
        $existing = $this->repo->findByEmail($dto->email);
        throw_if($existing, UserAlreadyExistsException::class);

        $createdBy = null;
        if ($dto->createdBy) {
            $createdBy = $this->repo->findById($dto->createdBy);
            throw_if(!$createdBy, UserNotFoundException::class);
        }

        $user = new UserEntity(
            id: 0,
            firstName: $dto->firstName,
            lastName: $dto->lastName,
            email: new UserEmail($dto->email),
            role: $dto->role,
            phone: $dto->phone,
            password: new HashedUserPassword(bcrypt($dto->password)),
            department: $dto->department,
            notes: $dto->notes,
            avatarUrl: $dto->avatarUrl,
            isActive: $dto->isActive ?? true,
            lastLogin: null,
            workOrders: [],
            createdAt: new UserCreatedAt(),
            updatedAt: new UserUpdatedAt(),
            createdBy: $createdBy,
            updatedBy: null
        );

        $created = $this->repo->create($user);

        $this->chronologyLogger->log(
            user: $createdBy,
            targetType: 'user',
            targetId: $created->getId(),
            eventType: 'created',
            description: 'Usuario creado',
            meta: [
                'email' => $created->getEmail()->value(),
                'role' => $created->getRole(),
            ]
        );

        return UserMapper::toDto($created, 'User created successfully.');
    }
}
