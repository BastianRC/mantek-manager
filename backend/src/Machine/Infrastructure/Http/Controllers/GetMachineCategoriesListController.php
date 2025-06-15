<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\GetMachineCategoriesListUseCase;

class GetMachineCategoriesListController
{
    public function __invoke(GetMachineCategoriesListUseCase $useCase)
    {
        $response = $useCase->execute();

        return response()->json($response->toArray());
    }
}
