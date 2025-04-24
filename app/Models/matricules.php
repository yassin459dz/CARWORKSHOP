<?php

namespace App\Models;
use App\Models\cars;
use App\Models\clients;

use Illuminate\Database\Eloquent\Model;

class matricules extends Model
{
    protected $fillable = [
        'client_id', // Ensure this is present if you want to link to Client
        'car_id',
        'mat',
        'km',
        'color',
        'anne',
        'work',
        'remark',

    ];
    protected $table = 'matricules';


    public function client()
    {
        return $this->belongsTo(clients::class); // If you need this association
    }

     public function car()
     {
         return $this->belongsTo(cars::class);
     }

     public function factures()
     {
        return $this->hasMany(Factures::class, 'matricule_id');
     }

}
