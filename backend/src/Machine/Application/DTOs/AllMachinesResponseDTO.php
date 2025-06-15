<?php

namespace Src\Machine\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllMachinesResponseDTO extends BaseResponseDto
{
    /**
     * @param MachineResponseDTO[] $machines
     */
    public function __construct(
        bool $success,
        string $message,
        public array $machines
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(
                fn(MachineResponseDTO $dto) => $dto->toArray()['data'],
                $this->machines
            ),
        ];
    }
}
