<?php

namespace App\Policies;

use App\User;
use App\Wsp;
use Illuminate\Auth\Access\HandlesAuthorization;

class WspPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any wsp.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the wsp.
     *
     * @param  App\User  $user
     * @param  App\Wsp  $wsp
     * @return bool
     */
    public function view(User $user, Wsp $wsp)
    {
        return false;
    }

    /**
     * Determine whether the user can create a wsp.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the wsp.
     *
     * @param  App\User  $user
     * @param  App\Wsp  $wsp
     * @return bool
     */
    public function update(User $user, Wsp $wsp)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the wsp.
     *
     * @param  App\User  $user
     * @param  App\Wsp  $wsp
     * @return bool
     */
    public function delete(User $user, Wsp $wsp)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the wsp.
     *
     * @param  App\User  $user
     * @param  App\Wsp  $wsp
     * @return bool
     */
    public function restore(User $user, Wsp $wsp)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the wsp.
     *
     * @param  App\User  $user
     * @param  App\Wsp  $wsp
     * @return bool
     */
    public function forceDelete(User $user, Wsp $wsp)
    {
        return false;
    }
}
