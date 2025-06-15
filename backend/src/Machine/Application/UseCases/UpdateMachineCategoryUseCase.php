<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\DTOs\UpdateMachineCategoryRequestDTO;
use Src\Machine\Application\Mappers\MachineCategoryMapper;
use Src\Machine\Domain\Exceptions\MachineCategoryNotFoundException;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Machine\Domain\ValueObject\MachineCategoryUpdatedAt;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class UpdateMachineCategoryUseCase
{
    public function __construct(
        private readonly MachineCategoryRepositoryInterface $repo,
        private readonly UserRepositoryInterface $userRepo
    ) {}

    public function execute(UpdateMachineCategoryRequestDTO $dto)
    {
        $category = $this->repo->findById($dto->id);
        throw_if(!$category, MachineCategoryNotFoundException::class);

        $user = $this->userRepo->findById($dto->updatedById);

        $updated = $category;

        $map = [
            'name' => fn($c, $v) => $c->changeName($v),
            'updatedById' => fn($c, $v) => $c->changeUpdatedBy($user),
        ];

        foreach ($map as $key => $callback) {
            if (!is_null($dto->$key)) {
                $updated = $callback($updated, $dto->$key);
            }
        }

        $updated = $updated->changeUpdatedAt(new MachineCategoryUpdatedAt());

        $saved = $this->repo->update($updated);

        return MachineCategoryMapper::toDto($saved, 'Machine category updated successfully.');
    }
}
