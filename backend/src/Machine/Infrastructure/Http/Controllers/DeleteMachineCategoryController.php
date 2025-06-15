<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\UseCases\DeleteMachineCategoryUseCase;

class DeleteMachineCategoryController
{
    public function __invoke(int $id, DeleteMachineCategoryUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray());
    }
}
