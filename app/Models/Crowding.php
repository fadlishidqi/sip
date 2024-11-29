<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Crowding extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'jumlah_pendaki',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getCrowdingStatusAttribute()
    {
        if ($this->jumlah_pendaki <= 50) {
            return 'low';
        } elseif ($this->jumlah_pendaki <= 100) {
            return 'medium';
        } else {
            return 'high';
        }
    }

    public function getCrowdingStatusTextAttribute()
    {
        return [
            'low' => 'Sepi',
            'medium' => 'Normal',
            'high' => 'Padat'
        ][$this->crowding_status];
    }
}