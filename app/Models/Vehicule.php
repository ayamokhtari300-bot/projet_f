<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $fillable = [
        'matricule',
        'type_voiture',
        'disponibilite'
    ];

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
}
