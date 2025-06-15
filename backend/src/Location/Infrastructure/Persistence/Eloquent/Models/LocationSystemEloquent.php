<?php

namespace Src\Location\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Location\Infrastructure\Persistence\Eloquent\Models\LocationEloquent;

class LocationSystemEloquent extends Model
{
    protected $table = 'location_systems';

    public $timestamps = false;

    protected $fillable = [
        'location_id',
        'system_type',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationEloquent::class, 'location_id');
    }
}
