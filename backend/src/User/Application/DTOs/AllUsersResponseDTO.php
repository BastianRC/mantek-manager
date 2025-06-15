<?php

namespace Src\User\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllUsersResponseDTO extends BaseResponseDto
{
    /**
     * @param UserResponseDTO[] $users
     */

    public function __construct(
        bool $success,
        string $message,
        public array $users
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(
                fn(UserResponseDTO $users) => $users->toArray()['data'],
                $this->users
            )
        ];
    }
}
