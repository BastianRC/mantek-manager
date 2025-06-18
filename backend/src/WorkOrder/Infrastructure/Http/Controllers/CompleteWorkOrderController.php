<?php

namespace Src\WorkOrder\Infrastructure\Http\Controllers;

use Src\WorkOrder\Application\UseCases\CompleteWorkOrderUseCase;

class CompleteWorkOrderController
{
    public function __invoke(int $id, CompleteWorkOrderUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}
