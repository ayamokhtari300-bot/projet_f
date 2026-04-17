<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $fillable = [
        'type_mission','destination', 'description', 'date_aller', 'date_retour', 
        'status', 'fichier', 'user_id', 'vehicule_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    public function agents()
    {
        return $this->belongsToMany(User::class, 'agent_missions', 'mission_id', 'agent_id')
                    ->withPivot('agent_type')
                    ->withTimestamps();
    }
}