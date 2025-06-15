<?php

namespace Src\Location\Application\UseCases;

use Src\Location\Application\DTOs\LocationDetailsResponseDTO;
use Src\Location\Application\DTOs\LocationResponseDTO;
use Src\Location\Application\Mappers\LocationMapper;
use Src\Location\Domain\Exceptions\LocationNotFoundException;
use Src\Location\Domain\Repository\LocationRepositoryInterface;

class GetLocationByIdUseCase
{
    public function __construct(
        private readonly LocationRepositoryInterface $repo
    ) {}

    public function execute(int $id): LocationDetailsResponseDTO
    {
        $location = $this->repo->findById($id);
        throw_if(!$location, LocationNotFoundException::class);

        return LocationMapper::toDetailsDto($location);
    }
}