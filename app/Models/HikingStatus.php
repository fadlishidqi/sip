<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HikingStatus extends Model
{
    protected $fillable = [
        'booking_id',
        'departure_time',
        'return_time',
        'status'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'return_time' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}