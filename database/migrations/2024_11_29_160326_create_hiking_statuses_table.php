<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void 
    {
        Schema::create('hiking_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->dateTime('departure_time')->nullable();
            $table->dateTime('return_time')->nullable();
            $table->enum('status', ['waiting', 'hiking', 'completed'])->default('waiting');
            $table->timestamps();

            // Add index for performance
            $table->index(['status', 'departure_time']);
            $table->index(['status', 'return_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hiking_statuses');
    }
};