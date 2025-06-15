<?php

namespace Src\Machine\Application\Mappers;

use Src\Machine\Application\DTOs\AllMachineDocumentsResponseDTO;
use Src\Machine\Application\DTOs\MachineDocumentResponseDTO;
use Src\Machine\Domain\Entities\MachineDocument;

class MachineDocumentMapper
{
    public static function toDto(MachineDocument $document, string $message = 'Machine document retrieved successfully.'): MachineDocumentResponseDTO
    {
        return new MachineDocumentResponseDTO(
            success: true,
            message: $message,
            id: $document->getId(),
            machine: $document->getMachine(),
            documentName: $document->getDocumentName(),
            filePath: $document->getFilePath(),
            fileSize: $document->getFileSize(),
            mimeType: $document->getMimeType(),
            uploadedBy: $document->getUploadedBy(),
            uploadedAt: $document->getUploadedAt()
        );
    }

    /**
     * @param MachineDocument[] $documents
     */
    public static function toCollectionDto(array $documents): AllMachineDocumentsResponseDTO
    {
        $dtos = array_map(
            fn(MachineDocument $doc) => self::toDto($doc),
            $documents
        );

        return new AllMachineDocumentsResponseDTO(
            success: true,
            message: 'Machine documents retrieved successfully.',
            documents: $dtos
        );
    }
}
