<?php

namespace Src\WorkOrder\Infrastructure\Http\Controllers;

use Src\WorkOrder\Application\UseCases\StartWorkOrderUseCase;

class StartWorkOrderController
{
    public function __invoke(int $id, StartWorkOrderUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}
