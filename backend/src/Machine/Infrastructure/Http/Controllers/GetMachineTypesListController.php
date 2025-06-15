<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\GetMachineTypesListUseCase;

class GetMachineTypesListController
{
    public function __invoke(GetMachineTypesListUseCase $useCase)
    {
        $response = $useCase->execute();

        return response()->json($response->toArray(), 200);
    }
}
