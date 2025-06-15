<?php

namespace Src\Machine\Domain\Entities;

use Src\Machine\Domain\ValueObject\MachineDocumentFileSize;
use Src\Machine\Domain\ValueObject\MachineDocumentMimeType;
use Src\Machine\Domain\ValueObject\MachineDocumentUploadedAt;
use Src\User\Domain\Entity\User;

interface MachineDocument
{
    public function getId(): int;

    public function getMachine(): Machine;

    public function getDocumentName(): string;

    public function getFilePath(): string;

    public function getFileSize(): MachineDocumentFileSize;

    public function getMimeType(): MachineDocumentMimeType;

    public function getUploadedAt(): MachineDocumentUploadedAt;

    public function getUploadedBy(): ?User;

    public function isPersisted(): bool;

    public function changeMachine(Machine $machine): self;

    public function changeDocumentName(string $documentName): self;

    public function changeFilePath(string $filePath): self;

    public function changeFileSize(MachineDocumentFileSize $fileSize): self;

    public function changeMimeType(MachineDocumentMimeType $mimeType): self;

    public function changeUploadedAt(MachineDocumentUploadedAt $uploadedAt): self;

    public function changeUploadedBy(?User $uploadedBy): self;
}
