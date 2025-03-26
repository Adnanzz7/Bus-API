<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory, HasApiTokens;

    public $incrementing = false;
    
    protected $primaryKey = 'driver_id';
    protected $keyType = 'string';
    protected $fillable = ['driver_id', 'name', 'age', 'gender', 'phone_number', 'address', 'email'];

    public function corridors()
    {
        return $this->hasMany(Corridor::class, 'driver_id');
    }
}
