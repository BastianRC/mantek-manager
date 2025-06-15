<?php

namespace Src\Chronology\Application\UseCases;

use Src\Chronology\Application\DTOs\AllChronologiesResponseDTO;
use Src\Chronology\Application\Mappers\ChronologyMapper;
use Src\Chronology\Domain\Repositories\ChronologyRepositoryInterface;
use Src\Chronology\Domain\ValueObject\ChronologyTargetType;

class GetChronologiesByTargetUseCase
{
    public function __construct(
        private readonly ChronologyRepositoryInterface $repo
    ) {}

    public function execute(string $targetType, int $targetId): AllChronologiesResponseDTO
    {
        $type = new ChronologyTargetType($targetType);

        $chronologies = $this->repo->findByTarget($type->value(), $targetId);

        return ChronologyMapper::toCollectionDto($chronologies, 'Cronología obtenida correctamente.');
    }
}
