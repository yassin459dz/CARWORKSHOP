<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factures extends Model
{
    protected $fillable = [
        'client_id',
        'car_id',
        'matricule_id',
        'km',
        'remark',
        'total_amount',
        'extra_charge',
        'discount_amount',
        'order_items',
        'status',


    ];
    protected $casts = [
        'order_items' => 'json',
        'total_amount' => 'decimal:2',
    ];
    public function client()
    {
        return $this->belongsTo(clients::class);
    }

    public function car()
    {
        return $this->belongsTo(cars::class);
    }

    public function matricule()
    {
        return $this->belongsTo(matricules::class); // Changed from hasMany to belongsTo
    }

    public function cashbox()
    {
        return $this->belongsTo(Cashbox::class, 'date', 'date');
    }
}
