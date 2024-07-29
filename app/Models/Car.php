<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', // Ensure this is present if you want to link to Client
        'brand',
        'model',
        'color',
        'mat',
        'km',
        'remark',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function bl() {
        return $this->hasMany(BL::class);
    }



}
