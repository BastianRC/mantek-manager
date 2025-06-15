<?php

namespace Src\Machine\Infrastructure\Mappers;

use Src\Machine\Domain\Entities\MachineDocumentEntity;
use Src\Machine\Domain\ValueObject\MachineDocumentFileSize;
use Src\Machine\Domain\ValueObject\MachineDocumentMimeType;
use Src\Machine\Domain\ValueObject\MachineDocumentUploadedAt;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineDocumentEloquent;
use Src\User\Infrastructure\Mappers\UserEntityMapper;

class MachineDocumentEntityMapper
{
    public static function toDomain(MachineDocumentEloquent $model): MachineDocumentEntity
    {
        return new MachineDocumentEntity(
            id: $model->id,
            machine: MachineEntityMapper::toDomain($model->machine),
            documentName: $model->document_name,
            filePath: $model->file_path,
            fileSize: new MachineDocumentFileSize($model->file_size),
            mimeType: new MachineDocumentMimeType($model->mime_type),
            uploadedBy: $model->uploadedBy ? UserEntityMapper::toDomain($model->uploadedBy) : null,
            uploadedAt: new MachineDocumentUploadedAt($model->uploaded_at),
        );
    }

    public static function toModel(MachineDocumentEntity $entity): MachineDocumentEloquent
    {
        $model = $entity->isPersisted()
            ? MachineDocumentEloquent::findOrFail($entity->getId())
            : new MachineDocumentEloquent();

        $model->machine_id = $entity->getMachine()->getId();
        $model->document_name = $entity->getDocumentName();
        $model->file_path = $entity->getFilePath();
        $model->file_size = $entity->getFileSize()->value();
        $model->mime_type = $entity->getMimeType()->value();
        $model->uploaded_by = $entity->getUploadedBy()?->getId();
        $model->uploaded_at = $entity->getUploadedAt()->value();

        return $model;
    }
}
