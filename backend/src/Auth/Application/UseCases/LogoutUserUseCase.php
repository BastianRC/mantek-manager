<?php

namespace Src\Auth\Application\UseCases;

use Src\Auth\Domain\Exceptions\UserNotFoundException;
use Src\Auth\Domain\Repositories\AuthUserRepositoryInterface;
use Src\Shared\Application\DTOs\BaseResponseDto;

class LogoutUserUseCase
{
    public function __construct(
        private AuthUserRepositoryInterface $repo,
    ) {}

    public function execute(): BaseResponseDto
    {
        $this->repo->deleteToken();

        return new BaseResponseDto(
            success: true,
            message: 'Successful logout'
        );
    }
}
