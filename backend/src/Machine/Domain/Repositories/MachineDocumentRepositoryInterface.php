<?php

namespace Src\Machine\Domain\Repositories;

use Src\Machine\Domain\Entities\MachineDocument;

interface MachineDocumentRepositoryInterface
{
    /**
     * @return MachineDocument[]
     */
    public function findByMachineId(int $machineId): array;

    public function findById(int $id): ?MachineDocument;

    public function upload(MachineDocument $document): MachineDocument;

    public function delete(MachineDocument $document): void;
}
