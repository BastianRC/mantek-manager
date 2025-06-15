<?php

namespace Src\Shared\Application\Mappers;

use Src\Shared\Application\DTOs\BaseResponseDto;

class ResponseMapper
{
    public static function toDto($message)
    {
        return new BaseResponseDto(
            success: true,
            message: $message
        );
    }
}
