<?php

namespace Src\Role\Infrastructure\Http\Controllers;

use Src\Role\Application\UseCases\DeleteRoleUseCase;

class DeleteRoleController
{
    public function __invoke(int $id, DeleteRoleUseCase $useCase)
    {
        $response = $useCase->execute($id);
        
        return response()->json($response->toArray(), 200);
    }
}
