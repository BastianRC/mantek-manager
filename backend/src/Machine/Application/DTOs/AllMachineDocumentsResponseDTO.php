<?php

namespace Src\Machine\Application\DTOs;

use Src\Shared\Application\DTOs\BaseResponseDto;

class AllMachineDocumentsResponseDTO extends BaseResponseDto
{
    /**
     * @param MachineDocumentResponseDTO[] $documents
     */
    public function __construct(
        bool $success,
        string $message,
        public array $documents
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => array_map(fn($doc) => $doc->toArray()['data'], $this->documents)
        ];
    }
}
