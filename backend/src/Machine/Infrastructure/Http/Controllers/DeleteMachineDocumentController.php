<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\DeleteMachineDocumentUseCase;

class DeleteMachineDocumentController
{
    public function __invoke(int $id, DeleteMachineDocumentUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}
