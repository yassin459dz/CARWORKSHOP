<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricule extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id', // Ensure this is present if you want to link to Client
        'car_id',
        'mat',
        'km',
        'anne',
        'work',
        'remark',

    ];



    public function client()
    {
        return $this->belongsTo(Client::class); // If you need this association
    }
     public function bl() {
         return $this->hasMany(BL::class);
     }

     public function car()
     {
         return $this->belongsTo(Car::class);
     }

}
