<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Domain\Exceptions\MachineTypeNotFoundException;
use Src\Machine\Domain\Repositories\MachineTypeRepositoryInterface;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;

class DeleteMachineTypeUseCase
{
    public function __construct(
        private readonly MachineTypeRepositoryInterface $repo
    ) {}

    public function execute(int $id): BaseResponseDto
    {
        $type = $this->repo->findById($id);
        throw_if(!$type, MachineTypeNotFoundException::class);

        $this->repo->delete($type);

        return ResponseMapper::toDto('Machine type deleted successfully.');
    }
}
