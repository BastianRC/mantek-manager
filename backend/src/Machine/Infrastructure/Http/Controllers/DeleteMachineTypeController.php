<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\DeleteMachineTypeUseCase;

class DeleteMachineTypeController
{
    public function __invoke(int $id, DeleteMachineTypeUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray());
    }
}
