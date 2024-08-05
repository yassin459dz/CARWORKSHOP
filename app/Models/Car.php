<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', // Ensure this is present if you want to link to Client
        //'brand_id',
      //  'color_id',
        'model',
        'remark',
    ];

    // public function client()
    // {
    //     return $this->belongsTo(Client::class);
    // }



    public function bl() {
        return $this->hasMany(BL::class);
    }

    public function matricule() {
        return $this->hasMany(Matricule::class);
    }

    // public function color() {
    //     return $this->hasMany(Color::class);
    // }

    // public function Brand()
    // {
    //     return $this->belongsTo(Brand::class); // If you need this association
    // }
}
