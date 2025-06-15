<?php

namespace Src\Chronology\Application\UseCases;

use DateTimeImmutable;
use Src\Chronology\Application\DTOs\ChronologyResponseDTO;
use Src\Chronology\Application\DTOs\CreateChronologyRequestDTO;
use Src\Chronology\Application\Mappers\ChronologyMapper;
use Src\Chronology\Domain\Entities\ChronologyEntity;
use Src\Chronology\Domain\Repositories\ChronologyRepositoryInterface;
use Src\Chronology\Domain\ValueObject\ChronologyCreatedAt;
use Src\Chronology\Domain\ValueObject\ChronologyMeta;
use Src\Chronology\Domain\ValueObject\ChronologyTargetType;
use Src\Chronology\Domain\ValueObject\ChronologyEventType;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class CreateChronologyUseCase
{
    public function __construct(
        private readonly ChronologyRepositoryInterface $repo,
        private readonly UserRepositoryInterface $userRepo
    ) {}

    public function execute(CreateChronologyRequestDTO $dto): ChronologyResponseDTO
    {
        $user = $dto->userId ? $this->userRepo->findById($dto->userId) : null;

        $chronology = new ChronologyEntity(
            id: 0,
            user: $user,
            targetType: new ChronologyTargetType($dto->targetType),
            targetId: $dto->targetId,
            eventType: new ChronologyEventType($dto->eventType),
            description: $dto->description,
            meta: $dto->meta ? new ChronologyMeta($dto->meta) : null,
            createdAt: new ChronologyCreatedAt(new DateTimeImmutable())
        );

        $this->repo->create($chronology);

        return ChronologyMapper::toDto($chronology, 'Evento cronologico registrado correctamente.');
    }
}
