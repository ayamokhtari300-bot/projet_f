<?php

namespace App\Policies;

use App\Models\Mission;
use App\Models\User;

class MissionPolicy
{
    /**
     * Determine whether the user can view the mission.
     */
    public function view(User $user, Mission $mission): bool
    {
        // Les validateurs et opérateurs peuvent tout voir
        if ($user->hasAnyRole(['validateur', 'operateur'])) {
            return true;
        }

        // Un agent ne peut voir que sa propre mission
        return $user->id === $mission->user_id;
    }

    /**
     * Determine whether the user can update the mission.
     */
    public function update(User $user, Mission $mission): bool
    {
        // Un validateur peut tout modifier
        if ($user->hasRole('validateur')) {
            return true;
        }

        // Un agent ne peut modifier que sa propre mission et si elle est encore en attente
        return $user->id === $mission->user_id && $mission->status === 'en_attente';
    }

    /**
     * Determine whether the user can delete the mission.
     */
    public function delete(User $user, Mission $mission): bool
    {
        // Un validateur peut tout supprimer
        if ($user->hasRole('validateur')) {
            return true;
        }

        // Un agent ne peut supprimer que sa propre mission et si elle est encore en attente
        return $user->id === $mission->user_id && $mission->status === 'en_attente';
    }
}
