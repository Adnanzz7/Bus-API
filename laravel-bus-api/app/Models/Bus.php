<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Bus extends Model
{
    /** @use HasFactory<\Database\Factories\BusFactory> */
    use HasFactory, HasApiTokens;

    protected $fillable = ['plate_number','brand','type','fuel'];
    
    public function corridors()
    {
        return $this->hasMany(Corridor::class);
    }
}
