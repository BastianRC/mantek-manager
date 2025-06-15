<?php

namespace Src\Machine\Application\DTOs;

use Src\Machine\Domain\Entities\Machine;
use Src\Machine\Domain\ValueObject\MachineDocumentFileSize;
use Src\Machine\Domain\ValueObject\MachineDocumentMimeType;
use Src\Machine\Domain\ValueObject\MachineDocumentUploadedAt;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;

class MachineDocumentResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public Machine $machine,
        public string $documentName,
        public string $filePath,
        public MachineDocumentFileSize $fileSize,
        public MachineDocumentMimeType $mimeType,
        public MachineDocumentUploadedAt $uploadedAt,
        public ?User $uploadedBy
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'document_name' => $this->documentName,
                'file_path' => $this->filePath,
                'file_size' => $this->fileSize->value(),
                'mime_type' => $this->mimeType->value(),
                'uploaded_at' => $this->uploadedAt->toString(),
                'uploaded_by' => $this->uploadedBy ? [
                    'id' => $this->uploadedBy->getId(),
                    'name' => $this->uploadedBy->getFullName()
                ] : null
            ]
        ];
    }
}
