<?php

namespace App\Models;
use App\Models\clients;
use App\Models\Factures;
use App\Models\matricules;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class cars extends Model
{
    protected $fillable = [
        'brand_id' ,
        'model' ,
    ];
    public function brand()
    {
        return $this->belongsTo(brands::class); // Singular "brand" for the method name
    }

    public function factures()
{
    return $this->hasMany(Factures::class);
}

public function matricules()
{
    return $this->hasMany(matricules::class);
}
}
