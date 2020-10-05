<?php

namespace App\Policies;

use App\User;
use App\Bcp;
use Illuminate\Auth\Access\HandlesAuthorization;

class BcpPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any bcp.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the bcp.
     *
     * @param  App\User  $user
     * @param  App\Bcp  $bcp
     * @return bool
     */
    public function view(User $user, Bcp $bcp)
    {
        return false;
    }

    /**
     * Determine whether the user can create a bcp.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the bcp.
     *
     * @param  App\User  $user
     * @param  App\Bcp  $bcp
     * @return bool
     */
    public function update(User $user, Bcp $bcp)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the bcp.
     *
     * @param  App\User  $user
     * @param  App\Bcp  $bcp
     * @return bool
     */
    public function delete(User $user, Bcp $bcp)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the bcp.
     *
     * @param  App\User  $user
     * @param  App\Bcp  $bcp
     * @return bool
     */
    public function restore(User $user, Bcp $bcp)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the bcp.
     *
     * @param  App\User  $user
     * @param  App\Bcp  $bcp
     * @return bool
     */
    public function forceDelete(User $user, Bcp $bcp)
    {
        return false;
    }
}
