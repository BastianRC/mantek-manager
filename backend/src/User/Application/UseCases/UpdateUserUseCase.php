<?php

namespace Src\User\Application\UseCases;

use Illuminate\Support\Facades\Log;
use Src\Role\Domain\Exceptions\RoleNotFoundException;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Application\DTOs\UpdateUserRequestDTO;
use Src\User\Application\DTOs\UserDetailsResponseDTO;
use Src\User\Application\DTOs\UserResponseDTO;
use Src\User\Application\Mappers\UserMapper;
use Src\User\Domain\Entity\User;
use Src\User\Domain\Exceptions\UserAlreadyExistsException;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserUpdatedAt;

class UpdateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repo,
        private readonly RoleRepositoryInterface $roleRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(UpdateUserRequestDTO $dto): UserDetailsResponseDTO
    {
        $user = $this->repo->findById($dto->id);
        throw_if(!$user, UserNotFoundException::class);

        if ($dto->email) {
            $existingUser = $this->repo->findByEmail($dto->email);
            if ($existingUser && $existingUser->getId() !== $user->getId()) {
                throw new UserAlreadyExistsException();
            }
        }

        $updatedUser = $user;

        $map = [
            'firstName'   => fn($user, $v) => $user->changeFirstName($v),
            'lastName'    => fn($user, $v) => $user->changeLastName($v),
            'email'       => fn($user, $v) => $user->changeEmail(new UserEmail($v)),
            'phone'       => fn($user, $v) => $user->changePhone($v),
            'password'    => fn($user, $v) => $user->changePassword(new HashedUserPassword(bcrypt($v))),
            'department'  => fn($user, $v) => $user->changeDepartment($v),
            'notes'       => fn($user, $v) => $user->changeNotes($v),
            'avatarUrl'   => fn($user, $v) => $user->changeAvatarUrl($v),
            'isActive'    => fn($user, $v) => $user->changeIsActive($v),
            'updatedBy'   => fn($user, $v) => $user->changeUpdatedBy($this->repo->findById($v)),
        ];

        foreach ($map as $key => $callback) {
            if (!is_null($dto->$key)) {
                $updatedUser = $callback($updatedUser, $dto->$key === '' ? null : $dto->$key);
            }
        }

        $updatedUser = $updatedUser->changeUpdatedAt(new UserUpdatedAt());

        $updated = $this->repo->update($updatedUser);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'user',
            targetId: $user->getId(),
            eventType: 'updated',
            description: 'Usuario actualizado',
            meta: [
                'email' => $user->getEmail()->value(),
                'role' => $user->getRole(),
            ]
        );

        return UserMapper::toDetailsDto($updated, 'User updated successfully.');
    }
}
