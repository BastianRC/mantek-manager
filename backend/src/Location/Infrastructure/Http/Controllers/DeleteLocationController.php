<?php

namespace Src\Location\Infrastructure\Http\Controllers;

use Src\Location\Application\UseCases\DeleteLocationUseCase;

class DeleteLocationController
{
    public function __invoke(int $id, DeleteLocationUseCase $useCase)
    {
        $response = $useCase->execute($id);
        return response()->json($response->toArray(), 200);
    }
}
