<?php

namespace App\Policies;

use App\User;
use App\Bcpteam;
use Illuminate\Auth\Access\HandlesAuthorization;

class BcpteamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any bcpteam.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the bcpteam.
     *
     * @param  App\User  $user
     * @param  App\Bcpteam  $bcpteam
     * @return bool
     */
    public function view(User $user, Bcpteam $bcpteam)
    {
        return false;
    }

    /**
     * Determine whether the user can create a bcpteam.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the bcpteam.
     *
     * @param  App\User  $user
     * @param  App\Bcpteam  $bcpteam
     * @return bool
     */
    public function update(User $user, Bcpteam $bcpteam)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the bcpteam.
     *
     * @param  App\User  $user
     * @param  App\Bcpteam  $bcpteam
     * @return bool
     */
    public function delete(User $user, Bcpteam $bcpteam)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the bcpteam.
     *
     * @param  App\User  $user
     * @param  App\Bcpteam  $bcpteam
     * @return bool
     */
    public function restore(User $user, Bcpteam $bcpteam)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the bcpteam.
     *
     * @param  App\User  $user
     * @param  App\Bcpteam  $bcpteam
     * @return bool
     */
    public function forceDelete(User $user, Bcpteam $bcpteam)
    {
        return false;
    }
}
