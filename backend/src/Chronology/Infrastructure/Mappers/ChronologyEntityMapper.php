<?php

namespace Src\Chronology\Infrastructure\Mappers;

use Src\Chronology\Domain\Entities\ChronologyEntity;
use Src\Chronology\Domain\ValueObject\ChronologyCreatedAt;
use Src\Chronology\Domain\ValueObject\ChronologyMeta;
use Src\Chronology\Domain\ValueObject\ChronologyTargetType;
use Src\Chronology\Domain\ValueObject\ChronologyEventType;
use Src\Chronology\Infrastructure\Persistence\Eloquent\Models\ChronologyEloquent;
use Src\User\Infrastructure\Mappers\UserEntityMapper;

class ChronologyEntityMapper
{
    public static function toDomain(ChronologyEloquent $model): ChronologyEntity
    {
        return new ChronologyEntity(
            id: $model->id,
            user: $model->user ? UserEntityMapper::toDomain($model->user) : null,
            targetType: new ChronologyTargetType($model->target_type),
            targetId: $model->target_id,
            eventType: new ChronologyEventType($model->event_type),
            description: $model->description,
            meta: $model->meta ? new ChronologyMeta($model->meta) : null,
            createdAt: new ChronologyCreatedAt($model->created_at)
        );
    }

    public static function toModel(ChronologyEntity $entity): ChronologyEloquent
    {
        return new ChronologyEloquent([
            'user_id' => $entity->getUser()?->getId(),
            'target_type' => $entity->getTargetType()->value(),
            'target_id' => $entity->getTargetId(),
            'event_type' => $entity->getEventType()->value(),
            'description' => $entity->getDescription(),
            'meta' => $entity->getMeta()?->value(),
            'created_at' => $entity->getCreatedAt()->toString(),
        ]);
    }
}
