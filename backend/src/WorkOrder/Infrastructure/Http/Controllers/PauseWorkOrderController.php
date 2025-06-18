<?php

namespace Src\WorkOrder\Infrastructure\Http\Controllers;

use Src\WorkOrder\Application\UseCases\PauseWorkOrderUseCase;

class PauseWorkOrderController
{
    public function __invoke(int $id, PauseWorkOrderUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}
