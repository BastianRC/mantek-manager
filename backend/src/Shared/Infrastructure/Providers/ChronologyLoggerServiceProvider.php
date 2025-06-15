<?php

namespace Src\Shared\Infrastructure\Providers;

use Carbon\Laravel\ServiceProvider;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\Shared\Infrastructure\Services\ChronologyLoggerService;

class ChronologyLoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ChronologyLoggerInterface::class, ChronologyLoggerService::class);
    }
}
