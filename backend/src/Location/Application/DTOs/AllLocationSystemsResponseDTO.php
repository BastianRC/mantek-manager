<?php

namespace Src\Location\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllLocationSystemsResponseDTO extends BaseResponseDto
{
    /**
     * @param LocationSystemOptionDTO[] $systems
     */
    public function __construct(
        bool $success,
        string $message,
        public array $systems
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(fn($s) => [
                'value' => $s->value,
                'label' => $s->label,
            ], $this->systems)
        ];
    }
}
