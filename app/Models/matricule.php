<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricule extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id', // Ensure this is present if you want to link to Client
        'car_id',
        'mat',
        'km',
        'anne',
        'work',
        'remark',

    ];


    // Method called before saving the model
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Ensure that `matricule_id` is set when saving
            if (is_null($model->id) && $model->mat) {
                // Logic to handle new matricule creation
                // For instance, assign a new ID or perform other actions
            }
        });

        // Optionally, use the `saved` method to handle post-save actions
        static::saved(function ($model) {
            // Actions to perform after saving
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class); // If you need this association
    }
     public function bl() {
         return $this->hasMany(BL::class);
     }

     public function car()
     {
         return $this->belongsTo(Car::class);
     }

}
