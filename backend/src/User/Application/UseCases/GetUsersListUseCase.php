<?php

namespace Src\User\Application\UseCases;

use Src\User\Application\DTOs\AllUsersResponseDTO;
use Src\User\Application\Mappers\UserMapper;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class GetUsersListUseCase
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {}

    public function execute(): AllUsersResponseDTO
    {
        $users = $this->repo->findAll();
        return UserMapper::toDtoCollection($users);
    }
}