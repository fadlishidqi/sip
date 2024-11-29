<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendakis', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama_lengkap')->nullable();
            $table->string('nik')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->integer('umur')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('no_telp_darurat')->nullable();
            $table->string('hubungan_darurat')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendakis');
    }
};
