<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\DTOs\CreateMachineTypeRequestDTO;
use Src\Machine\Application\Mappers\MachineTypeMapper;
use Src\Machine\Domain\Entities\MachineTypeEntity;
use Src\Machine\Domain\Repositories\MachineTypeRepositoryInterface;
use Src\Machine\Domain\ValueObject\MachineTypeCreatedAt;
use Src\Machine\Domain\ValueObject\MachineTypeUpdatedAt;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class CreateMachineTypeUseCase
{
    public function __construct(
        private readonly MachineTypeRepositoryInterface $repo,
        private readonly UserRepositoryInterface $userRepo
    ) {}

    public function execute(CreateMachineTypeRequestDTO $dto)
    {
        $creator = $this->userRepo->findById($dto->createdById);

        $type = new MachineTypeEntity(
            id: 0,
            name: $dto->name,
            createdBy: $creator,
            updatedBy: $creator,
            createdAt: new MachineTypeCreatedAt(),
            updatedAt: new MachineTypeUpdatedAt()
        );

        $saved = $this->repo->create($type);

        return MachineTypeMapper::toDto($saved, 'Machine type created successfully.');
    }
}
