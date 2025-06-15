<?php

namespace Src\Location\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Location\Infrastructure\Persistence\Eloquent\Models\LocationEloquent;

class LocationZoneEloquent extends Model
{
    protected $table = 'location_zones';

    public $timestamps = false;
    
    protected $fillable = [
        'location_id',
        'zone_name',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationEloquent::class, 'location_id');
    }
}
