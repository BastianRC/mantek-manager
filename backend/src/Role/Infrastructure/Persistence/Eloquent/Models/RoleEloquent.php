<?php

namespace Src\Role\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

class RoleEloquent extends SpatieRole
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_active',
        'created_by',
        'updated_by',
        'guard_name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            PermissionEloquent::class,
            'role_has_permissions',
            'role_id',
            'permission_id'
        );
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
