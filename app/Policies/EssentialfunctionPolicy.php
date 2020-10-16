<?php

namespace App\Policies;

use App\User;
use App\Essentialfunction;
use Illuminate\Auth\Access\HandlesAuthorization;

class EssentialfunctionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any essentialfunction.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the essentialfunction.
     *
     * @param  App\User  $user
     * @param  App\Essentialfunction  $essentialfunction
     * @return bool
     */
    public function view(User $user, Essentialfunction $essentialfunction)
    {
        return false;
    }

    /**
     * Determine whether the user can create a essentialfunction.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the essentialfunction.
     *
     * @param  App\User  $user
     * @param  App\Essentialfunction  $essentialfunction
     * @return bool
     */
    public function update(User $user, Essentialfunction $essentialfunction)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the essentialfunction.
     *
     * @param  App\User  $user
     * @param  App\Essentialfunction  $essentialfunction
     * @return bool
     */
    public function delete(User $user, Essentialfunction $essentialfunction)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the essentialfunction.
     *
     * @param  App\User  $user
     * @param  App\Essentialfunction  $essentialfunction
     * @return bool
     */
    public function restore(User $user, Essentialfunction $essentialfunction)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the essentialfunction.
     *
     * @param  App\User  $user
     * @param  App\Essentialfunction  $essentialfunction
     * @return bool
     */
    public function forceDelete(User $user, Essentialfunction $essentialfunction)
    {
        return false;
    }
}
