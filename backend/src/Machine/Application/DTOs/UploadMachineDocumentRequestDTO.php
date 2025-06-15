<?php

namespace Src\Machine\Application\DTOs;

class UploadMachineDocumentRequestDTO
{
    public function __construct(
        public int $machineId,
        public string $documentName,
        public int $fileSize,
        public string $fileContent,
        public string $mimeType,
        public int $uploadedById
    ) {}
}
