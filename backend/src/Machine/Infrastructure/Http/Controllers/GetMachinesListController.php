<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\GetMachinesListUseCase;

class GetMachinesListController
{
    public function __invoke(GetMachinesListUseCase $useCase)
    {
        $response = $useCase->execute();

        return response()->json($response->toArray(), 200);
    }
}
