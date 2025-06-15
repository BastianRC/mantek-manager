<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\GetMachineByIdUseCase;

class GetMachineByIdController
{
    public function __invoke(int $id, GetMachineByIdUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}
