<?php

namespace Src\WorkOrder\Infrastructure\Http\Controllers;

use Src\WorkOrder\Application\UseCases\GetWorkOrderByIdUseCase;

class GetWorkOrderByIdController
{
    public function __invoke(int $id, GetWorkOrderByIdUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}