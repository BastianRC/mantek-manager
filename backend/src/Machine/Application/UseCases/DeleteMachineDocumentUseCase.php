<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Domain\Exceptions\MachineDocumentNotFoundException;
use Src\Machine\Domain\Repositories\MachineDocumentRepositoryInterface;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;
use Src\Shared\Domain\Repositories\FileStorageRepositoryInterface;

class DeleteMachineDocumentUseCase
{
    public function __construct(
        private MachineDocumentRepositoryInterface $repoMachineDoc,
        private FileStorageRepositoryInterface $storageRepo
    ) {}

    public function execute(int $id): BaseResponseDto
    {
        $document = $this->repoMachineDoc->findById($id);
        throw_if(!$document, MachineDocumentNotFoundException::class);

        if ($this->storageRepo->exists($document->getFilePath())) {
            $this->storageRepo->delete($document->getFilePath());
        }

        $this->repoMachineDoc->delete($document);

        return ResponseMapper::toDto('Document deleted successfully.');
    }
}
