<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'bukti_pembayaran',
        'bank_pengirim',
        'nama_pengirim',
        'status',
        'catatan',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function pendaki()
    {
        return $this->hasOneThrough(
            Pendaki::class,  
            Booking::class,
            'id',
            'id', 
            'booking_id',
            'pendaki_id'
        );
    }
}