<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('corridors', function (Blueprint $table) {
            $table->id();
            $table->string('corridor_code');
            $table->string('driver_id');
            $table->foreignId('bus_id')->constrained('buses');
            $table->date('duty_date');
            $table->time('start_time');
            $table->time('finish_time');
            $table->integer('duty_time_in_minutes');
            $table->timestamps();
        
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corridors');
    }
};
