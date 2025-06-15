<?php

namespace Src\Machine\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

class MachineDocumentEloquent extends Model
{
    protected $table = 'machine_documents';
    public $timestamps = false;

    protected $fillable = [
        'machine_id',
        'document_name',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_at',
        'uploaded_by',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function machine(): BelongsTo
    {
        return $this->belongsTo(MachineEloquent::class, 'machine_id');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'uploaded_by');
    }
}
