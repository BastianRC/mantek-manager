<?php

namespace Src\Shared\Infrastructure\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Src\Shared\Domain\Repositories\FileStorageRepositoryInterface;

class FileStorageLaravelRepository implements FileStorageRepositoryInterface
{
    public function store(string $path, string $fileName, string $extension, string $contents): string
    {
        $slug = Str::slug(pathinfo($fileName, PATHINFO_FILENAME));
        $timestamp = now()->format('YmdHis');

        $uniqueFileName = "{$slug}_{$timestamp}.{$extension}";
        $fullPath = "{$path}/{$uniqueFileName}";

        Storage::put($fullPath, $contents);

        return $fullPath;
    }

    public function delete(string $path): void
    {
        Storage::delete($path);
    }

    public function exists(string $path): bool
    {
        return Storage::exists($path);
    }
}
