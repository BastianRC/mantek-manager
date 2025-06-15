<?php

namespace Src\Auth\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Src\Auth\Application\UseCases\ValidateUserUseCase;

class ValidateUserController
{
    public function __invoke(Request $request, ValidateUserUseCase $useCase)
    {
        $user = $request->user();

        $response = $useCase->execute($user->email);

        return response()->json($response->toArray(), 200);
    }
}
