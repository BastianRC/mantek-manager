<?php

namespace Src\WorkOrder\Infrastructure\Http\Controllers;

use Src\WorkOrder\Application\UseCases\GetWorkOrdersListUseCase;

class GetWorkOrdersListController
{
    public function __invoke(GetWorkOrdersListUseCase $useCase)
    {
        $response = $useCase->execute();

        return response()->json($response->toArray(), 200);
    }
}