<?php

namespace Src\Chronology\Infrastructure\Repositories;

use Src\Chronology\Domain\Entities\Chronology;
use Src\Chronology\Domain\Repositories\ChronologyRepositoryInterface;
use Src\Chronology\Infrastructure\Mappers\ChronologyEntityMapper;
use Src\Chronology\Infrastructure\Persistence\Eloquent\Models\ChronologyEloquent;

class ChronologyEloquentRepository implements ChronologyRepositoryInterface
{
    public function findAll(): array
    {
        return ChronologyEloquent::with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($model) => ChronologyEntityMapper::toDomain($model))
            ->all();
    }

    public function findByTarget(string $targetType, int $targetId): array
    {
        return ChronologyEloquent::with('user')
            ->where('target_type', $targetType)
            ->where('target_id', $targetId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($model) => ChronologyEntityMapper::toDomain($model))
            ->all();
    }

    public function findByUserId(int $userId): array
    {
        return ChronologyEloquent::with('user')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($model) => ChronologyEntityMapper::toDomain($model))
            ->all();
    }

    public function create(Chronology $chronology): void
    {
        $model = ChronologyEntityMapper::toModel($chronology);
        $model->save();
    }
}
