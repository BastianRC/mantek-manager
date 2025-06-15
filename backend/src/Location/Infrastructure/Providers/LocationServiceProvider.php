<?php

namespace Src\Location\Infrastructure\Providers;

use Carbon\Laravel\ServiceProvider;

use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Location\Domain\Repository\LocationSystemRepositoryInterface;
use Src\Location\Domain\Repository\LocationZoneRepositoryInterface;
use Src\Location\Infrastructure\Repositories\LocationEloquentRepository;
use Src\Location\Infrastructure\Repositories\LocationSystemEloquentRepository;
use Src\Location\Infrastructure\Repositories\LocationZoneEloquentRepository;

class LocationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LocationRepositoryInterface::class, LocationEloquentRepository::class);
    }
}