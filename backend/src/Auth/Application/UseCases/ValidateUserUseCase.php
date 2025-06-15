<?php

namespace Src\Auth\Application\UseCases;

use Src\Auth\Application\DTOs\ValidateResponseDto;
use Src\Auth\Domain\Repositories\AuthUserRepositoryInterface;
use Src\Auth\Domain\ValueObject\UserEmail;

class ValidateUserUseCase
{
    public function __construct(
        private readonly AuthUserRepositoryInterface $repo
    ) {}

    public function execute(string $email): ValidateResponseDto
    {
        $user = $this->repo->findByEmail((new UserEmail($email))->value());

        return new ValidateResponseDto(
            success: true,
            message: 'User has been successfully validated.',
            id: $user->getId(),
            email: $user->getEmail()->value(),
            name: $user->getName(),
            role: $user->getRole(),
            permissions: $user->getPermissions(),
        );
    }
}
