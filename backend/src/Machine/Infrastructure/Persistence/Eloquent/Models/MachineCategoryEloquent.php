<?php

namespace Src\Machine\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

class MachineCategoryEloquent extends Model
{
    protected $table = 'machine_categories';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'updated_by');
    }
}
