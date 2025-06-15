<?php

namespace Src\Location\Infrastructure\Http\Controllers;

use Src\Location\Application\UseCases\GetLocationTypesListUseCase;

class GetLocationTypesListController
{
    public function __invoke(GetLocationTypesListUseCase $useCase)
    {
        return response()->json($useCase->execute()->toArray(), 200);
    }
}
