<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'pendaki_id',
        'tanggal_naik',
        'tanggal_turun',
        'jumlah_anggota',
        'status',
    ];

    protected $casts = [
        'tanggal_naik' => 'datetime',
        'tanggal_turun' => 'datetime',
    ];

    public function pendaki()
    {
        return $this->belongsTo(Pendaki::class, 'pendaki_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function hikingStatus()
    {
        return $this->hasOne(HikingStatus::class);
    }
}