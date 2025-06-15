<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\DTOs\UpdateMachineTypeRequestDTO;
use Src\Machine\Application\Mappers\MachineTypeMapper;
use Src\Machine\Domain\Exceptions\MachineTypeNotFoundException;
use Src\Machine\Domain\Repositories\MachineTypeRepositoryInterface;
use Src\Machine\Domain\ValueObject\MachineTypeUpdatedAt;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class UpdateMachineTypeUseCase
{
    public function __construct(
        private readonly MachineTypeRepositoryInterface $repo,
        private readonly UserRepositoryInterface $userRepo
    ) {}

    public function execute(UpdateMachineTypeRequestDTO $dto)
    {
        $type = $this->repo->findById($dto->id);
        throw_if(!$type, MachineTypeNotFoundException::class);

        $user = $this->userRepo->findById($dto->updatedById);

        $updated = $type;

        $map = [
            'name' => fn($t, $v) => $t->changeName($v),
            'updatedById' => fn($t, $v) => $t->changeUpdatedBy($user),
        ];

        foreach ($map as $key => $callback) {
            if (!is_null($dto->$key)) {
                $updated = $callback($updated, $dto->$key);
            }
        }

        $updated = $updated->changeUpdatedAt(new MachineTypeUpdatedAt());

        $saved = $this->repo->update($updated);

        return MachineTypeMapper::toDto($saved, 'Machine type updated successfully.');
    }
}
