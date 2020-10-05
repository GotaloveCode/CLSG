<?php

namespace App\Policies;

use App\User;
use App\EssentialOperation;
use Illuminate\Auth\Access\HandlesAuthorization;

class EssentialOperationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any essentialOperation.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the essentialOperation.
     *
     * @param  App\User  $user
     * @param  App\EssentialOperation  $essentialOperation
     * @return bool
     */
    public function view(User $user, EssentialOperation $essentialOperation)
    {
        return false;
    }

    /**
     * Determine whether the user can create a essentialOperation.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the essentialOperation.
     *
     * @param  App\User  $user
     * @param  App\EssentialOperation  $essentialOperation
     * @return bool
     */
    public function update(User $user, EssentialOperation $essentialOperation)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the essentialOperation.
     *
     * @param  App\User  $user
     * @param  App\EssentialOperation  $essentialOperation
     * @return bool
     */
    public function delete(User $user, EssentialOperation $essentialOperation)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the essentialOperation.
     *
     * @param  App\User  $user
     * @param  App\EssentialOperation  $essentialOperation
     * @return bool
     */
    public function restore(User $user, EssentialOperation $essentialOperation)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the essentialOperation.
     *
     * @param  App\User  $user
     * @param  App\EssentialOperation  $essentialOperation
     * @return bool
     */
    public function forceDelete(User $user, EssentialOperation $essentialOperation)
    {
        return false;
    }
}
