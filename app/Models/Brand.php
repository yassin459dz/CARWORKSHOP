<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_id', // Ensure this is present if you want to link to Client
        'brand',
    ];
    public function car() {
        return $this->hasMany(Car::class);
    }
}
