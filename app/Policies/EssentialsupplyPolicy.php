<?php

namespace App\Policies;

use App\User;
use App\Essentialsupply;
use Illuminate\Auth\Access\HandlesAuthorization;

class EssentialsupplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any essentialsupply.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the essentialsupply.
     *
     * @param  App\User  $user
     * @param  App\Essentialsupply  $essentialsupply
     * @return bool
     */
    public function view(User $user, Essentialsupply $essentialsupply)
    {
        return false;
    }

    /**
     * Determine whether the user can create a essentialsupply.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the essentialsupply.
     *
     * @param  App\User  $user
     * @param  App\Essentialsupply  $essentialsupply
     * @return bool
     */
    public function update(User $user, Essentialsupply $essentialsupply)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the essentialsupply.
     *
     * @param  App\User  $user
     * @param  App\Essentialsupply  $essentialsupply
     * @return bool
     */
    public function delete(User $user, Essentialsupply $essentialsupply)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the essentialsupply.
     *
     * @param  App\User  $user
     * @param  App\Essentialsupply  $essentialsupply
     * @return bool
     */
    public function restore(User $user, Essentialsupply $essentialsupply)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the essentialsupply.
     *
     * @param  App\User  $user
     * @param  App\Essentialsupply  $essentialsupply
     * @return bool
     */
    public function forceDelete(User $user, Essentialsupply $essentialsupply)
    {
        return false;
    }
}
