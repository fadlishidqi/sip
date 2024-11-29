<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pendaki extends Authenticatable
{
    use Notifiable;

    protected $table = 'pendakis';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'nik',
        'jenis_kelamin',
        'umur',
        'alamat',
        'no_telp',
        'no_telp_darurat',
        'hubungan_darurat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}