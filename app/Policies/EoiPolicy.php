<?php

namespace App\Policies;

use App\User;
use App\Eoi;
use Illuminate\Auth\Access\HandlesAuthorization;

class EoiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any eoi.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the eoi.
     *
     * @param  App\User  $user
     * @param  App\Eoi  $eoi
     * @return bool
     */
    public function view(User $user, Eoi $eoi)
    {
        return false;
    }

    /**
     * Determine whether the user can create a eoi.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the eoi.
     *
     * @param  App\User  $user
     * @param  App\Eoi  $eoi
     * @return bool
     */
    public function update(User $user, Eoi $eoi)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the eoi.
     *
     * @param  App\User  $user
     * @param  App\Eoi  $eoi
     * @return bool
     */
    public function delete(User $user, Eoi $eoi)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the eoi.
     *
     * @param  App\User  $user
     * @param  App\Eoi  $eoi
     * @return bool
     */
    public function restore(User $user, Eoi $eoi)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the eoi.
     *
     * @param  App\User  $user
     * @param  App\Eoi  $eoi
     * @return bool
     */
    public function forceDelete(User $user, Eoi $eoi)
    {
        return false;
    }
}
