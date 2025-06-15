<?php

namespace Src\Machine\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllMachineCategoriesResponseDTO extends BaseResponseDto
{
    /**
     * @param MachineCategoryResponseDTO[] $categories
     */
    public function __construct(
        bool $success,
        string $message,
        public array $categories
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(
                fn(MachineCategoryResponseDTO $dto) => $dto->toArray()['data'],
                $this->categories
            )
        ];
    }
}
