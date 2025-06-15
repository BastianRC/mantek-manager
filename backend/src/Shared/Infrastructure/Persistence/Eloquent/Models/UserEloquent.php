<?php

namespace Src\Shared\Infrastructure\Persistence\Eloquent\Models;

use Database\Factories\UserEloquentFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserEloquent extends Authenticatable
{
    use HasFactory, HasApiTokens, HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'department',
        'notes',
        'avatar_url',
        'is_active',
        'last_login',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    protected $guard_name = 'sanctum';

    protected static function newFactory()
    {
        return UserEloquentFactory::new();
    }

    public function creator()
    {
        return $this->belongsTo(self::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(self::class, 'updated_by');
    }
}
