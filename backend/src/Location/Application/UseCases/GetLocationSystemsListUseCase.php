<?php

namespace Src\Location\Application\UseCases;

use Src\Location\Application\DTOs\AllLocationSystemsResponseDTO;
use Src\Location\Application\Mappers\LocationSystemMapper;

class GetLocationSystemsListUseCase
{
    public function execute(): AllLocationSystemsResponseDTO
    {
        return LocationSystemMapper::toCollectionDto();
    }
}
