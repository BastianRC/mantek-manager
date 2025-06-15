<?php

namespace Src\Machine\Application\DTOs;

use Src\Machine\Domain\ValueObject\MachineCategoryCreatedAt;
use Src\Machine\Domain\ValueObject\MachineCategoryUpdatedAt;
use Src\Shared\Application\DTOs\BaseResponseDto;

class MachineCategoryResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $name,
        public MachineCategoryCreatedAt $createdAt,
        public MachineCategoryUpdatedAt $updatedAt
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
