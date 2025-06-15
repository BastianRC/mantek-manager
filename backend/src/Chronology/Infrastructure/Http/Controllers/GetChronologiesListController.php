<?php

namespace Src\Chronology\Infrastructure\Http\Controllers;

use Src\Chronology\Application\UseCases\GetChronologiesListUseCase;

class GetChronologiesListController
{
    public function __invoke(GetChronologiesListUseCase $useCase)
    {
        $response = $useCase->execute();

        return response()->json($response->toArray(), 200);
    }
}
