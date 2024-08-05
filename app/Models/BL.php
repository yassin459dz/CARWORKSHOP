<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BL extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'car_id',
        'matricule_id',
        'km',
        'mat',
        'bl_number',
        'product',
        'price',
        'qte',
        'km',
        'total',
        'remark',
    ];
    public function client()
    {
        return $this->hasMany(client::class);
    }

    public function car()
    {
        return $this->hasMany(car::class);
    }

    public function brand()
    {
        return $this->hasMany(Brand::class);
    }

    // public function matricule()
    // {
    //     return $this->hasMany(matricule::class);
    // }

    public function matricule()
    {
        return $this->belongsTo(Matricule::class); // Changed from hasMany to belongsTo
    }


}
