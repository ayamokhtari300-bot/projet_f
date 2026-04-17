<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentMission extends Model
{
    protected $table = 'agent_missions';

    protected $fillable = [
        'mission_id',
        'agent_id',
        'agent_type'
    ];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
