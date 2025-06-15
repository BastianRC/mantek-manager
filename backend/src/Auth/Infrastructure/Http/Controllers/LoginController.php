<?php

namespace Src\Auth\Infrastructure\Http\Controllers;

use Src\Auth\Application\DTOs\LoginRequestDto;
use Src\Auth\Application\UseCases\LoginUserUseCase;
use Src\Auth\Infrastructure\Http\Requests\LoginRequest;

class LoginController
{
    public function __invoke(LoginRequest $request, LoginUserUseCase $useCase)
    {
        $dto = new LoginRequestDto(
            email: $request->input('email'),
            password: $request->input('password')
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 200);
    }
}
