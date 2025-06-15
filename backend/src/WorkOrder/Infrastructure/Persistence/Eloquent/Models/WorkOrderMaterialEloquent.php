<?php

namespace Src\WorkOrder\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderMaterialEloquent extends Model
{
    protected $table = 'work_order_materials';

    protected $fillable = [
        'work_order_id',
        'material_name',
        'quantity',
        'unit',
    ];

    public $timestamps = false;

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrderEloquent::class, 'work_order_id');
    }
}
