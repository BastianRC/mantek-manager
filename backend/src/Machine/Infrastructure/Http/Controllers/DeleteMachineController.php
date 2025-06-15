<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\DeleteMachineUseCase;

class DeleteMachineController
{
    public function __invoke(int $id, DeleteMachineUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}
