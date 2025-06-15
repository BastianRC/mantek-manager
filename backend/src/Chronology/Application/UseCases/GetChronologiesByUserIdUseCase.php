<?php

namespace Src\Chronology\Application\UseCases;

use Src\Chronology\Application\DTOs\AllChronologiesResponseDTO;
use Src\Chronology\Application\Mappers\ChronologyMapper;
use Src\Chronology\Domain\Repositories\ChronologyRepositoryInterface;

class GetChronologiesByUserIdUseCase
{
    public function __construct(
        private readonly ChronologyRepositoryInterface $repo
    ) {}

    public function execute(int $userId): AllChronologiesResponseDTO
    {
        $chronologies = $this->repo->findByUserId($userId);

        return ChronologyMapper::toCollectionDto($chronologies, 'Cronología del usuario obtenida correctamente.');
    }
}
