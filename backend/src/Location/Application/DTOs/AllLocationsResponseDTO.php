<?php

namespace Src\Location\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllLocationsResponseDTO extends BaseResponseDto
{
    /**
     * @param LocationResponseDTO[] $locations
     */
    public function __construct(
        bool $success,
        string $message,
        public array $locations
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(
                fn(LocationResponseDTO $dto) => $dto->toArray()['data'],
                $this->locations
            )
        ];
    }
}
