<?php

namespace Src\Location\Infrastructure\Http\Controllers;

use Src\Location\Application\UseCases\GetLocationsListUseCase;

class GetLocationsListController
{
    public function __invoke(GetLocationsListUseCase $useCase)
    {
        $response = $useCase->execute();
        return response()->json($response->toArray(), 200);
    }
}
