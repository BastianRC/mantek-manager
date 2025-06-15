<?php

namespace Src\Machine\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllMachineTypesResponseDTO extends BaseResponseDto
{
    /**
     * @param MachineTypeResponseDTO[] $types
     */
    public function __construct(
        bool $success,
        string $message,
        public array $types
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(
                fn(MachineTypeResponseDTO $dto) => $dto->toArray()['data'],
                $this->types
            ),
        ];
    }
}
