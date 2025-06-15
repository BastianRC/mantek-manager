<?php

namespace Src\Shared\Domain\Repositories;

interface FileStorageRepositoryInterface
{
    public function store(string $path, string $fileName, string $extension, string $contents): string;
    public function delete(string $path): void;
    public function exists(string $path): bool;
}
