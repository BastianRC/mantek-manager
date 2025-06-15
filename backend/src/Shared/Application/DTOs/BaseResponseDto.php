<?php

namespace Src\Shared\Application\DTOs;

class BaseResponseDto
{
    public function __construct(
        public bool $success,
        public string $message
    ) {}
    
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message
        ];
    }
}