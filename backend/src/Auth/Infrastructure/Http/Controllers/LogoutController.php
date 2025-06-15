<?php

namespace Src\Auth\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Src\Auth\Application\UseCases\LogoutUserUseCase;

class LogoutController
{
    public function __invoke(LogoutUserUseCase $useCase)
    {
        $response = $useCase->execute();

        return response()->json($response->toArray(), 200);
    }
}