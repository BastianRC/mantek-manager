<?php

namespace Src\Machine\Domain\ValueObject;

use InvalidArgumentException;

class MachineDocumentMimeType
{
    private const ALLOWED_TYPES = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpeg',
        'image/png' => 'png',
        'image/jpg' => 'jpg',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
    ];

    public function __construct(
        private readonly string $type
    ) {
        if (!array_key_exists($type, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException("Invalid MIME type: $type");
        }
    }

    public function value(): string
    {
        return $this->type;
    }

    public function extension(): string
    {
        return self::ALLOWED_TYPES[$this->type];
    }


    public static function allowed(): array
    {
        return array_keys(self::ALLOWED_TYPES);
    }
}
