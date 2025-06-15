<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Domain\Exceptions\MachineNotFoundException;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;

class DeleteMachineUseCase
{
    public function __construct(
        private readonly MachineRepositoryInterface $repo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(int $id): BaseResponseDto
    {
        $machine = $this->repo->findById($id);

        throw_if(!$machine, MachineNotFoundException::class);

        $this->repo->delete($machine);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'machine',
            targetId: $machine->getId(),
            eventType: 'deleted',
            description: 'Máquina eliminada',
            meta: []
        );

        return ResponseMapper::toDto('Machine deleted successfully.');
    }
}
