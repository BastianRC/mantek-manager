<?php

namespace Src\Auth\Application\UseCases;

use Src\Auth\Application\DTOs\LoginRequestDto;
use Src\Auth\Application\DTOs\LoginResponseDto;
use Src\Auth\Domain\Exceptions\InvalidCredentialsException;
use Src\Auth\Domain\Exceptions\UserNotFoundException;
use Src\Auth\Domain\Repositories\AuthUserRepositoryInterface;
use Src\Auth\Domain\ValueObject\HashedUserPassword;

class LoginUserUseCase
{
    public function __construct(
        private AuthUserRepositoryInterface $repo,
    ) {}

    public function execute(LoginRequestDto $dto)
    {
        $user = $this->repo->findByEmail($dto->email);
        throw_if(!$user, UserNotFoundException::class);

        if (!(new HashedUserPassword($user->getPassword()->value()))->matches($dto->password)) {
            throw new InvalidCredentialsException();
        }

        $token = $this->repo->createToken($user);

        return new LoginResponseDto(
            success: true,
            message: 'Successful login.',
            id: $user->getId(),
            email: $user->getEmail()->value(),
            name: $user->getName(),
            token: $token,
            role: $user->getRole(),
            permissions:  $user->getPermissions()
        );
    }
}
