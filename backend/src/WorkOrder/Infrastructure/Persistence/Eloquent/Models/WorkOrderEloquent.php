<?php

namespace Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Location\Infrastructure\Persistence\Eloquent\Models\LocationEloquent;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineCategoryEloquent;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineEloquent;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

class WorkOrderEloquent extends Model
{
    protected $table = 'work_orders';

    protected $fillable = [
        'order_number',
        'title',
        'type',
        'description',
        'priority',
        'status',
        'assignee_id',
        'machine_id',
        'location_id',
        'due_at',
        'paused_at',
        'started_at',
        'completed_at',
        'resumed_at',
        'estimated_hours',
        'actual_hours',
        'requested_by',
        'approved_by',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'paused_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'resumed_at' => 'datetime',
        'estimated_hours' => 'float',
        'actual_hours' => 'float',
    ];

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'assignee_id');
    }

    public function machine(): BelongsTo
    {
        return $this->belongsTo(MachineEloquent::class, 'machine_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationEloquent::class, 'location_id');
    }

    public function materials(): HasMany
    {
        return $this->hasMany(WorkOrderMaterialEloquent::class, 'work_order_id');
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
