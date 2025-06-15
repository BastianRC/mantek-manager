<?php

namespace Src\Machine\Domain\Entities;

use Src\Machine\Domain\ValueObject\MachineDocumentUploadedAt;
use Src\User\Domain\Entity\User;
use Src\Machine\Domain\Entities\Machine;
use Src\Machine\Domain\ValueObject\MachineDocumentFileSize;
use Src\Machine\Domain\ValueObject\MachineDocumentMimeType;

class MachineDocumentEntity implements MachineDocument
{
    public function __construct(
        private int $id,
        private Machine $machine,
        private string $documentName,
        private string $filePath,
        private MachineDocumentFileSize $fileSize,
        private MachineDocumentMimeType $mimeType,
        private MachineDocumentUploadedAt $uploadedAt,
        private ?User $uploadedBy,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getMachine(): Machine
    {
        return $this->machine;
    }

    public function getDocumentName(): string
    {
        return $this->documentName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getFileSize(): MachineDocumentFileSize
    {
        return $this->fileSize;
    }

    public function getMimeType(): MachineDocumentMimeType
    {
        return $this->mimeType;
    }

    public function getUploadedAt(): MachineDocumentUploadedAt
    {
        return $this->uploadedAt;
    }

    public function getUploadedBy(): ?User
    {
        return $this->uploadedBy;
    }

    public function isPersisted(): bool
    {
        return $this->id !== 0;
    }

    public function changeMachine(Machine $machine): self
    {
        return $this->withClone(fn($m) => $m->machine = $machine);
    }

    public function changeDocumentName(string $documentName): self
    {
        return $this->withClone(fn($m) => $m->documentName = $documentName);
    }

    public function changeFilePath(string $filePath): self
    {
        return $this->withClone(fn($m) => $m->filePath = $filePath);
    }

    public function changeFileSize(MachineDocumentFileSize $fileSize): self
    {
        return $this->withClone(fn($m) => $m->fileSize = $fileSize);
    }

    public function changeMimeType(MachineDocumentMimeType $mimeType): self
    {
        return $this->withClone(fn($m) => $m->mimeType = $mimeType);
    }

    public function changeUploadedAt(MachineDocumentUploadedAt $uploadedAt): self
    {
        return $this->withClone(fn($m) => $m->uploadedAt = $uploadedAt);
    }

    public function changeUploadedBy(?User $uploadedBy): self
    {
        return $this->withClone(fn($m) => $m->uploadedBy = $uploadedBy);
    }

    private function withClone(\Closure $callback): self
    {
        $clone = clone $this;
        $callback($clone);
        return $clone;
    }
}
