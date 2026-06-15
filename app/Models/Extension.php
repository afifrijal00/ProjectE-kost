<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    protected $fillable = [
        'tenant_id',
        'duration',
        'amount',
        'transfer_date',
        'sender_name',
        'proof_photo',
        'status',
        'notes',
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}