<?php

namespace Src\Chronology\Application\UseCases;

use Src\Chronology\Application\DTOs\AllChronologiesResponseDTO;
use Src\Chronology\Application\Mappers\ChronologyMapper;
use Src\Chronology\Domain\Repositories\ChronologyRepositoryInterface;

class GetChronologiesListUseCase
{
    public function __construct(
        private readonly ChronologyRepositoryInterface $repo
    ) {}

    public function execute(): AllChronologiesResponseDTO
    {
        $chronologies = $this->repo->findAll();

        return ChronologyMapper::toCollectionDto(
            $chronologies,
            'Lista de cronología obtenida correctamente.'
        );
    }
}
