<?php

namespace Src\Role\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllRolesResponseDto extends BaseResponseDto
{
    /**
     * @param RoleResponseDTO[] $roles
     */
    public function __construct(
        bool $success,
        string $message,
        public array $roles
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(
                fn(RoleResponseDTO $dto) => $dto->toArray()['data'],
                $this->roles
            )
        ];
    }
}
