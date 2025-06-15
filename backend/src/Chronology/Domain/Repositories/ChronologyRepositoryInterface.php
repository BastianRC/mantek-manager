<?php

namespace Src\Chronology\Domain\Repositories;

use Src\Chronology\Domain\Entities\Chronology;

interface ChronologyRepositoryInterface
{
    /**
     * @return Chronology[]
     */
    public function findAll(): array;

    /**
     * @return Chronology[]
     */
    public function findByTarget(string $targetType, int $targetId): array;

    /**
     * @return Chronology[]
     */
    public function findByUserId(int $userId): array;

    public function create(Chronology $chronology): void;
}
