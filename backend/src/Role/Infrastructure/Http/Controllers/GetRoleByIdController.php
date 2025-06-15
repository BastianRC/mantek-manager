<?php

namespace Src\Role\Infrastructure\Http\Controllers;

use Src\Role\Application\UseCases\GetRoleByIdUseCase;

class GetRoleByIdController
{
    public function __invoke(int $id, GetRoleByIdUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}