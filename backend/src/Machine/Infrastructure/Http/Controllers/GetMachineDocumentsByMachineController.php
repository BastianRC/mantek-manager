<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\GetMachineDocumentsByMachineUseCase;

class GetMachineDocumentsByMachineController
{
    public function __invoke(int $id, GetMachineDocumentsByMachineUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}
