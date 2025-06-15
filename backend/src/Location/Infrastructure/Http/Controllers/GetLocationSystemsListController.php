<?php

namespace Src\Location\Infrastructure\Http\Controllers;

use Src\Location\Application\UseCases\GetLocationSystemsListUseCase;

class GetLocationSystemsListController
{
    public function __invoke(GetLocationSystemsListUseCase $useCase)
    {
        return response()->json($useCase->execute()->toArray(), 200);
    }
}
