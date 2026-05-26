<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'tenant_id',
        'title',
        'category',
        'description',
        'photo',
        'status',
        'admin_response',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}