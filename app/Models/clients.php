<?php

namespace App\Models;

use App\Models\cars;
use App\Models\matricules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class clients extends Model
{
    protected $fillable = [
        'name' ,
        'phone' ,
        'phone2' ,
        'address',
        'remark',
        'sold',
    ];

    public function cars()
{
    return $this->hasMany(cars::class);
}

public function matricules()
{
    return $this->hasMany(matricules::class);
}
}
