<?php

namespace Src\Shared\Infrastructure\Providers;

use Carbon\Laravel\ServiceProvider;
use Src\Shared\Domain\Repositories\FileStorageRepositoryInterface;
use Src\Shared\Infrastructure\Repositories\FileStorageLaravelRepository;

class FileStorageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FileStorageRepositoryInterface::class, FileStorageLaravelRepository::class);
    }
}
