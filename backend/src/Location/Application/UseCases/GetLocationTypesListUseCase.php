<?php

namespace Src\Location\Application\UseCases;

use Src\Location\Application\DTOs\AllLocationTypesResponseDTO;
use Src\Location\Application\Mappers\LocationTypeMapper;

class GetLocationTypesListUseCase
{
    public function execute(): AllLocationTypesResponseDTO
    {
        return LocationTypeMapper::toCollectionDto();
    }
}
