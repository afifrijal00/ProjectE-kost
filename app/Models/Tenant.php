<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tenant extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'name',
        'email',
        'phone',
        'nik',
        'ktp_photo',
        'emergency_contact',
        'duration',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Auto hitung end_date dari start_date + duration
    public static function calculateEndDate($startDate, $duration): Carbon
{
    return Carbon::parse($startDate)->addMonths((int) $duration);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}

public function latestPayment()
{
    return $this->hasOne(Payment::class)->latest();
}

public function complaints()
{
    return $this->hasMany(Complaint::class);
}

}