<?php

namespace Src\Chronology\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllChronologiesResponseDTO extends BaseResponseDto
{
    /**
     * @param ChronologyResponseDTO[] $chronologies
     */
    public function __construct(
        bool $success,
        string $message,
        public array $chronologies
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(
                fn(ChronologyResponseDTO $dto) => $dto->toArray()['data'],
                $this->chronologies
            )
        ];
    }
}
