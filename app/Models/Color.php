<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_id', // Ensure this is present if you want to link to Client
        'color',
    ];
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}

