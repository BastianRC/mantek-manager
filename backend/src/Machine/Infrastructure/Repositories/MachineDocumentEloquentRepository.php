<?php

namespace Src\Machine\Infrastructure\Repositories;

use Src\Machine\Domain\Entities\MachineDocument;
use Src\Machine\Domain\Repositories\MachineDocumentRepositoryInterface;
use Src\Machine\Infrastructure\Mappers\MachineDocumentEntityMapper;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineDocumentEloquent;

class MachineDocumentEloquentRepository implements MachineDocumentRepositoryInterface
{
    public function findByMachineId(int $machineId): array
    {
        return MachineDocumentEloquent::with(['machine', 'uploadedBy'])
            ->where('machine_id', $machineId)
            ->get()
            ->map(fn($model) => MachineDocumentEntityMapper::toDomain($model))
            ->all();
    }

    public function findById(int $id): ?MachineDocument
    {
        $model = MachineDocumentEloquent::with(['machine', 'uploadedBy'])->find($id);

        return $model ? MachineDocumentEntityMapper::toDomain($model) : null;
    }

    public function upload(MachineDocument $document): MachineDocument
    {
        $model = MachineDocumentEntityMapper::toModel($document);
        $model->save();

        return MachineDocumentEntityMapper::toDomain($model);
    }

    public function delete(MachineDocument $document): void
    {
        $model = MachineDocumentEloquent::findOrFail($document->getId());
        $model->delete();
    }
}
