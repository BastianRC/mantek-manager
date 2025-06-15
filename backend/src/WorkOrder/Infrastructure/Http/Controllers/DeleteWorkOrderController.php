<?php

namespace Src\WorkOrder\Infrastructure\Http\Controllers;

use Src\WorkOrder\Application\UseCases\DeleteWorkOrderUseCase;

class DeleteWorkOrderController
{
    public function __invoke(int $id, DeleteWorkOrderUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}