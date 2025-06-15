<?php

namespace Src\Machine\Domain\ValueObject;

use InvalidArgumentException;

class MachineDocumentFileSize
{
    private const MAX_FILE_SIZE = 10_485_760;

    public function __construct(
        private readonly int $bytes
    ) {
        if ($bytes <= 0 || $bytes > self::MAX_FILE_SIZE) {
            throw new InvalidArgumentException("Invalid file size: $bytes bytes. Max allowed: " . self::MAX_FILE_SIZE);
        }
    }

    public function value(): int
    {
        return $this->bytes;
    }

    public static function max(): int
    {
        return self::MAX_FILE_SIZE;
    }

    public static function maxKilobytes(): int
{
    return (int) ceil(self::MAX_FILE_SIZE / 1024);
}
}
