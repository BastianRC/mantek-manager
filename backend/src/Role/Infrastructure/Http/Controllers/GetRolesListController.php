<?php

namespace Src\Role\Infrastructure\Http\Controllers;

use Src\Role\Application\UseCases\GetRolesListUseCase;

class GetRolesListController
{
    public function __invoke(GetRolesListUseCase $useCase)
    {
        $response = $useCase->execute();

        return response()->json($response->toArray(), 200);
    }
}