<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\DTOs\CreateMachineCategoryRequestDTO;
use Src\Machine\Application\Mappers\MachineCategoryMapper;
use Src\Machine\Domain\Entities\MachineCategoryEntity;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Machine\Domain\ValueObject\MachineCategoryCreatedAt;
use Src\Machine\Domain\ValueObject\MachineCategoryUpdatedAt;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class CreateMachineCategoryUseCase
{
    public function __construct(
        private readonly MachineCategoryRepositoryInterface $repo,
        private readonly UserRepositoryInterface $userRepo
    ) {}

    public function execute(CreateMachineCategoryRequestDTO $dto)
    {
        $creator = $this->userRepo->findById($dto->createdById);

        $category = new MachineCategoryEntity(
            id: 0,
            name: $dto->name,
            createdBy: $creator,
            updatedBy: $creator,
            createdAt: new MachineCategoryCreatedAt(),
            updatedAt: new MachineCategoryUpdatedAt()
        );

        $saved = $this->repo->create($category);

        return MachineCategoryMapper::toDto($saved, 'Machine category created successfully.');
    }
}
