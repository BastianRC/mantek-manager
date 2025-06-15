<?php

namespace Src\Location\Infrastructure\Http\Controllers;

use Src\Location\Application\UseCases\GetLocationByIdUseCase;

class GetLocationByIdController
{
    public function __invoke(int $id, GetLocationByIdUseCase $useCase)
    {
        $response = $useCase->execute($id);
        return response()->json($response->toArray(), 200);
    }
}
