<?php

namespace App\Policies;

use App\User;
use App\Operationcost;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperationcostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any operationcost.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the operationcost.
     *
     * @param  App\User  $user
     * @param  App\Operationcost  $operationcost
     * @return bool
     */
    public function view(User $user, Operationcost $operationcost)
    {
        return false;
    }

    /**
     * Determine whether the user can create a operationcost.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the operationcost.
     *
     * @param  App\User  $user
     * @param  App\Operationcost  $operationcost
     * @return bool
     */
    public function update(User $user, Operationcost $operationcost)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the operationcost.
     *
     * @param  App\User  $user
     * @param  App\Operationcost  $operationcost
     * @return bool
     */
    public function delete(User $user, Operationcost $operationcost)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the operationcost.
     *
     * @param  App\User  $user
     * @param  App\Operationcost  $operationcost
     * @return bool
     */
    public function restore(User $user, Operationcost $operationcost)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the operationcost.
     *
     * @param  App\User  $user
     * @param  App\Operationcost  $operationcost
     * @return bool
     */
    public function forceDelete(User $user, Operationcost $operationcost)
    {
        return false;
    }
}
