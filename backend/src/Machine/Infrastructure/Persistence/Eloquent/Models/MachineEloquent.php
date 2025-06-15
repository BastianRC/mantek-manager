<?php

namespace Src\Machine\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Location\Infrastructure\Persistence\Eloquent\Models\LocationEloquent;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models\WorkOrderEloquent;

class MachineEloquent extends Model
{
    protected $table = 'machines';

    protected $fillable = [
        'name',
        'type_id',
        'category_id',
        'machine_model',
        'serial_number',
        'manufacturer',
        'location_id',
        'description',
        'install_date',
        'warranty_expiry',
        'supplier',
        'operating_temperature_min',
        'operating_temperature_max',
        'operating_pressure_max',
        'power_consumption',
        'voltage',
        'frequency',
        'weight',
        'dimensions',
        'maintenance_interval_days',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'install_date' => 'date',
        'warranty_expiry' => 'date',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(MachineTypeEloquent::class, 'type_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MachineCategoryEloquent::class, 'category_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationEloquent::class, 'location_id');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrderEloquent::class, 'machine_id');
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
