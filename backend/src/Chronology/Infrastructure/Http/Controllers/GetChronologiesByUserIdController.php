<?php

namespace Src\Chronology\Infrastructure\Http\Controllers;

use Src\Chronology\Application\UseCases\GetChronologiesByUserIdUseCase;

class GetChronologiesByUserIdController
{
    public function __invoke(int $id, GetChronologiesByUserIdUseCase $useCase)
    {
        $response = $useCase->execute($id);
        return response()->json($response->toArray(), 200);
    }
}
