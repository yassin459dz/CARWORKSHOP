<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'WORKSHOP',
        'ADDRESS',
        'PHONE',
        'PHONE2',
        'PHONE3',
        'FOOTER',
    ];
}
