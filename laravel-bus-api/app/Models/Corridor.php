<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Corridor extends Model
{
    /** @use HasFactory<\Database\Factories\CorridorFactory> */
    use HasFactory, HasApiTokens;

    protected $fillable = ['corridor_code', 'driver_id', 'bus_id', 'duty_date', 'start_time', 'finish_time', 'duty_time_in_minutes'];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
