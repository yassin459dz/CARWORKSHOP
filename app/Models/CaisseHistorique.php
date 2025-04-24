<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaisseHistorique extends Model
{
    protected $fillable = [
        'date', 'type', 'montant', 'description', 'cashbox_id'
    ];
    public function cashbox()
    {
        return $this->belongsTo(Cashbox::class);
    }
    public function facture()
    {
        return $this->belongsTo(Factures::class);
    }
}
