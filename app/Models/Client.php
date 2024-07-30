<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id', // Ensure this is present if you want to link to CAR
        'name',
        'phone',
        'phone2',
        'address',
        'sold',
        'remark',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
