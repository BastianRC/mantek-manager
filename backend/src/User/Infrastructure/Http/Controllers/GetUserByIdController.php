<?php

namespace Src\User\Infrastructure\Http\Controllers;

use Src\User\Application\UseCases\GetUserByIdUseCase;
use Src\User\Domain\Exceptions\UserNotFoundException;

class GetUserByIdController
{
    public function __invoke(int $id, GetUserByIdUseCase $useCase)
    {
        $response = $useCase->execute($id);

        return response()->json($response->toArray(), 200);
    }
}
