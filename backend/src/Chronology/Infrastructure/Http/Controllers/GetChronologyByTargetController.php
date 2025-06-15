<?php

namespace Src\Chronology\Infrastructure\Http\Controllers;

use Src\Chronology\Application\UseCases\GetChronologiesByTargetUseCase;

class GetChronologyByTargetController
{
    public function __invoke(string $type, int $id, GetChronologiesByTargetUseCase $useCase)
    {
        $response = $useCase->execute($type, $id);

        return response()->json($response->toArray(), 200);
    }
}
