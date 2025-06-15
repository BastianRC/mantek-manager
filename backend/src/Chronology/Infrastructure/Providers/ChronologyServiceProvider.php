<?php

namespace Src\Chronology\Infrastructure\Providers;
use Illuminate\Support\ServiceProvider;
use Src\Chronology\Domain\Repositories\ChronologyRepositoryInterface;
use Src\Chronology\Infrastructure\Repositories\ChronologyEloquentRepository;

class ChronologyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ChronologyRepositoryInterface::class, ChronologyEloquentRepository::class);
    }
}
