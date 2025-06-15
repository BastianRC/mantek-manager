<?php

namespace Src\User\Application\UseCases;

use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Application\DTOs\DeleteUserResponseDTO;
use Src\User\Domain\Exceptions\CannotDeleteLastSuperAdminException;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class DeleteUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(int $id): BaseResponseDto
    {
        $user = $this->repo->findById($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $this->repo->delete($user);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'user',
            targetId: $user->getId(),
            eventType: 'deleted',
            description: 'Usuario eliminado',
            meta: []
        );

        return ResponseMapper::toDto('User deleted successfully.');
    }
}
