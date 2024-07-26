<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'NAME',
        'PHONE',
        'PHONE2',
        'ADDRESS',
        'REMARK',
    ];
    public function car() {
        return $this->hasMany(car::class);
    }

    
}
