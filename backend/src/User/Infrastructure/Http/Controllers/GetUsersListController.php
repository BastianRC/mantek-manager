<?php

namespace Src\User\Infrastructure\Http\Controllers;

use Src\User\Application\UseCases\GetUsersListUseCase;

class GetUsersListController
{
    public function __invoke(GetUsersListUseCase $useCase)
    {
        $response = $useCase->execute();
        
        return response()->json($response->toArray(), 200);
    }
}
