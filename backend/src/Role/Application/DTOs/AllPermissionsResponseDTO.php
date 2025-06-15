<?php

namespace Src\Role\Application\DTOs;

use Src\Role\Domain\Entities\Permission;
use Src\Shared\Application\DTOs\BaseResponseDto;

class AllPermissionsResponseDTO extends BaseResponseDto
{
    /**
     * @param Permission[] $permissions
     */

    public function __construct(
        bool $success,
        string $message,
        public array $permissions
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->permissions
        ];
    }
}
