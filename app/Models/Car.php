<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'BRAND',
        'MODEL',
        'COLOR',
        'MAT',
        'KM',
        'REMARK',
    ];
    public function client()
    {
        return $this->belongsTo(client::class);
    }
}
