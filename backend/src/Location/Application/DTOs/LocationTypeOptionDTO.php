<?php

namespace Src\Location\Application\DTOs;

use Src\Location\Domain\ValueObject\LocationSystemCreatedAt;
use Src\Location\Domain\ValueObject\LocationSystemType;
use Src\Shared\Application\DTOs\BaseResponseDto;

class LocationTypeOptionDTO
{
    public function __construct(
        public string $value,
        public string $label,
    ) {}

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label,
        ];
    }
}
