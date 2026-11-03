<?php

namespace App\Policies;

use App\Models\Terrain;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TerrainPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Terrain $terrain): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
        public function update(User $user, Terrain $terrain): bool
{
    // Autorisé SI c'est le propriétaire OU SI c'est un administrateur
    return $terrain->user_id === $user->id || $user->role === User::ROLE_ADMIN;
}

    public function delete(User $user, Terrain $terrain): bool
    {
        return $this->update($user, $terrain);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Terrain $terrain): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Terrain $terrain): bool
    {
        return false;
    }
}
