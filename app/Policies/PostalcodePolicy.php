<?php

namespace App\Policies;

use App\User;
use App\Postalcode;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostalcodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any postalcode.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the postalcode.
     *
     * @param  App\User  $user
     * @param  App\Postalcode  $postalcode
     * @return bool
     */
    public function view(User $user, Postalcode $postalcode)
    {
        return false;
    }

    /**
     * Determine whether the user can create a postalcode.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the postalcode.
     *
     * @param  App\User  $user
     * @param  App\Postalcode  $postalcode
     * @return bool
     */
    public function update(User $user, Postalcode $postalcode)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the postalcode.
     *
     * @param  App\User  $user
     * @param  App\Postalcode  $postalcode
     * @return bool
     */
    public function delete(User $user, Postalcode $postalcode)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the postalcode.
     *
     * @param  App\User  $user
     * @param  App\Postalcode  $postalcode
     * @return bool
     */
    public function restore(User $user, Postalcode $postalcode)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the postalcode.
     *
     * @param  App\User  $user
     * @param  App\Postalcode  $postalcode
     * @return bool
     */
    public function forceDelete(User $user, Postalcode $postalcode)
    {
        return false;
    }
}
