<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devi extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'cars_id',
        'DEVI_NUMBER',
        'PRODUCT',
        'PRICE',
        'QTE',
        'TOTAL',
        'REMARK',
    ];

    public function client()
    {
        return $this->hasMany(client::class);
    }

    public function car()
    {
        return $this->hasMany(car::class);
    }
}
