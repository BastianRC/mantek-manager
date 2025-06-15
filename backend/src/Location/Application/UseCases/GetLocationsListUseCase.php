<?php

namespace Src\Location\Application\UseCases;

use Src\Location\Application\DTOs\AllLocationsResponseDTO;
use Src\Location\Application\Mappers\LocationMapper;
use Src\Location\Domain\Repository\LocationRepositoryInterface;

class GetLocationsListUseCase
{
    public function __construct(
        private readonly LocationRepositoryInterface $repo
    ) {}

    public function execute(): AllLocationsResponseDTO
    {
        $locations = $this->repo->findAll();
        
        return LocationMapper::toCollectionDto($locations);
    }
}
