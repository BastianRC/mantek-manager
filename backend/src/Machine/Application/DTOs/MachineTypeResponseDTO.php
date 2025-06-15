<?php

namespace Src\Machine\Application\DTOs;

use Src\Machine\Domain\ValueObject\MachineTypeCreatedAt;
use Src\Machine\Domain\ValueObject\MachineTypeUpdatedAt;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;

class MachineTypeResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $name,
        public MachineTypeCreatedAt $createdAt,
        public MachineTypeUpdatedAt $updatedAt
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'created_at' => $this->createdAt->toString(),
                'updated_at' => $this->updatedAt->toString()
            ]
        ];
    }
}
