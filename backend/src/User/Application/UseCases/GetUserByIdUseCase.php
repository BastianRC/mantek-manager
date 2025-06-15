<?php

namespace Src\User\Application\UseCases;

use Src\User\Application\DTOs\UserDetailsResponseDTO;
use Src\User\Application\DTOs\UserResponseDTO;
use Src\User\Application\Mappers\UserMapper;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class GetUserByIdUseCase
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {}

    public function execute(int $id): UserDetailsResponseDTO
    {
        $user = $this->repo->findById($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return UserMapper::toDetailsDto($user);
    }
}
