<?php

namespace Src\Machine\Application\UseCases;

use Src\Auth\Domain\Exceptions\UserNotFoundException;
use Src\Machine\Application\DTOs\MachineDocumentResponseDTO;
use Src\Machine\Application\DTOs\UploadMachineDocumentRequestDTO;
use Src\Machine\Application\Mappers\MachineDocumentMapper;
use Src\Machine\Domain\Entities\MachineDocumentEntity;
use Src\Machine\Domain\Exceptions\MachineNotFoundException;
use Src\Machine\Domain\Repositories\MachineDocumentRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;
use Src\Machine\Domain\ValueObject\MachineDocumentFileSize;
use Src\Machine\Domain\ValueObject\MachineDocumentMimeType;
use Src\Machine\Domain\ValueObject\MachineDocumentUploadedAt;
use Src\Shared\Domain\Repositories\FileStorageRepositoryInterface;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class UploadMachineDocumentUseCase
{
    public function __construct(
        private MachineDocumentRepositoryInterface $docRepo,
        private MachineRepositoryInterface $machineRepo,
        private UserRepositoryInterface $userRepo,
        private FileStorageRepositoryInterface $storageRepo
    ) {}

    public function execute(UploadMachineDocumentRequestDTO $dto): MachineDocumentResponseDTO
    {
        $machine = $this->machineRepo->findById($dto->machineId);
        throw_if(!$machine, MachineNotFoundException::class);

        $user = $this->userRepo->findById($dto->uploadedById);
        throw_if(!$user, UserNotFoundException::class);

        $fileSize = new MachineDocumentFileSize($dto->fileSize);
        $mimeType = new MachineDocumentMimeType($dto->mimeType);

        $path = $this->storageRepo->store(
            path: 'machine-documents',
            fileName: $dto->documentName,
            extension: $mimeType->extension(),
            contents: $dto->fileContent
        );

        $document = new MachineDocumentEntity(
            id: 0,
            machine: $machine,
            documentName: $dto->documentName,
            filePath: $path,
            fileSize: $fileSize,
            mimeType: $mimeType,
            uploadedBy: $user,
            uploadedAt: new MachineDocumentUploadedAt()
        );

        $uploaded = $this->docRepo->upload($document);

        return MachineDocumentMapper::toDto($uploaded, 'Document uploaded successfully.');
    }
}
