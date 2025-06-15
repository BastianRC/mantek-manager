<?php

namespace Src\Location\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineEloquent;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models\WorkOrderEloquent;

class LocationEloquent extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'name',
        'type',
        'description',
        'address',
        'floor',
        'latitude',
        'longitude',
        'manager_id',
        'emergency_contact',
        'emergency_phone',
        'access_requirements',
        'operating_hours',
        'notes',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'floor' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'manager_id' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'manager_id');
    }

    public function zones(): HasMany
    {
        return $this->hasMany(LocationZoneEloquent::class, 'location_id');
    }

    public function systems(): HasMany
    {
        return $this->hasMany(LocationSystemEloquent::class, 'location_id');
    }
    
    public function machines()
    {
        return $this->hasMany(MachineEloquent::class, 'location_id');
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrderEloquent::class, 'location_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'updated_by');
    }
}
