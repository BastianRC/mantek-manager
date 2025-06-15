<?php

namespace Src\User\Infrastructure\Http\Controllers;

use Src\User\Application\UseCases\DeleteUserUseCase;

class DeleteUserController
{
    public function __invoke(int $id, DeleteUserUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}