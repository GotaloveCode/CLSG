<?php

namespace App\Policies;

use App\User;
use App\Estimatedcost;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstimatedcostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any estimatedcost.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the estimatedcost.
     *
     * @param  App\User  $user
     * @param  App\Estimatedcost  $estimatedcost
     * @return bool
     */
    public function view(User $user, Estimatedcost $estimatedcost)
    {
        return false;
    }

    /**
     * Determine whether the user can create a estimatedcost.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the estimatedcost.
     *
     * @param  App\User  $user
     * @param  App\Estimatedcost  $estimatedcost
     * @return bool
     */
    public function update(User $user, Estimatedcost $estimatedcost)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the estimatedcost.
     *
     * @param  App\User  $user
     * @param  App\Estimatedcost  $estimatedcost
     * @return bool
     */
    public function delete(User $user, Estimatedcost $estimatedcost)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the estimatedcost.
     *
     * @param  App\User  $user
     * @param  App\Estimatedcost  $estimatedcost
     * @return bool
     */
    public function restore(User $user, Estimatedcost $estimatedcost)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the estimatedcost.
     *
     * @param  App\User  $user
     * @param  App\Estimatedcost  $estimatedcost
     * @return bool
     */
    public function forceDelete(User $user, Estimatedcost $estimatedcost)
    {
        return false;
    }
}
