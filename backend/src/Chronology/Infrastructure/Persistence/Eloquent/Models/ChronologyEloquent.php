<?php

namespace Src\Chronology\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

class ChronologyEloquent extends Model
{
    protected $table = 'chronology';

    public $timestamps = false;

    protected $fillable = [
        'target_type',
        'target_id',
        'user_id',
        'event_type',
        'description',
        'meta',
        'created_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'user_id');
    }
}
