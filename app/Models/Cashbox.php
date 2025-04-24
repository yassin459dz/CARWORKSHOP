<?php

namespace App\Models;
use App\Models\CaisseHistorique;
use App\Models\Factures;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Cashbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_value',
        'end_value',

    ];

    // Allow created_at to be mass assigned for when we create records for specific dates
    protected $guarded = ['id', 'updated_at'];

    public function mouvements()
    {
        return $this->hasMany(CaisseHistorique::class);
    }

    public function invoices()
    {
        return $this->hasMany(Factures::class, 'date', 'date');
    }
}
