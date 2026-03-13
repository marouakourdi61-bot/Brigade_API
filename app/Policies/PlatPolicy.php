<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Plat;

class PlatPolicy
{
    /**
     * Voir tous les plats
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Voir un plat
     */
    public function view(User $user, Plat $plat)
    {
        return $user->id === $plat->user_id;
    }

    /**
     * Créer plat
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Modifier 
     */
    public function update(User $user, Plat $plat)
    {
        return $user->id === $plat->user_id;
    }

    /**
     * Supprimer 
     */
    public function delete(User $user, Plat $plat)
    {
        return $user->id === $plat->user_id;
    }
}