<?php

namespace App\Models;
use App\Models\cars;
use Illuminate\Database\Eloquent\Model;

class brands extends Model
{
    protected $fillable = [
        'brand' ,
        'image' ,
    ];
      public function cars() {
          return $this->hasMany(cars::class);
      }

}
