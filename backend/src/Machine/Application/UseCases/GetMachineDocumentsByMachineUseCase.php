<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\DTOs\AllMachineDocumentsResponseDTO;
use Src\Machine\Application\Mappers\MachineDocumentMapper;
use Src\Machine\Domain\Exceptions\MachineNotFoundException;
use Src\Machine\Domain\Repositories\MachineDocumentRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;

class GetMachineDocumentsByMachineUseCase
{
    public function __construct(
        private MachineDocumentRepositoryInterface $repo,
        private MachineRepositoryInterface $machineRepo
    ) {}

    public function execute(int $machineId): AllMachineDocumentsResponseDTO
    {
        $machine = $this->machineRepo->findById($machineId);
        throw_if(!$machine, MachineNotFoundException::class);

        $documents = $this->repo->findByMachineId($machineId);

        return MachineDocumentMapper::toCollectionDto($documents);
    }
}
