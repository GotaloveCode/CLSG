<?php

namespace App\Policies;

use App\User;
use App\Revenue;
use Illuminate\Auth\Access\HandlesAuthorization;

class RevenuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any revenue.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the revenue.
     *
     * @param  App\User  $user
     * @param  App\Revenue  $revenue
     * @return bool
     */
    public function view(User $user, Revenue $revenue)
    {
        return false;
    }

    /**
     * Determine whether the user can create a revenue.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the revenue.
     *
     * @param  App\User  $user
     * @param  App\Revenue  $revenue
     * @return bool
     */
    public function update(User $user, Revenue $revenue)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the revenue.
     *
     * @param  App\User  $user
     * @param  App\Revenue  $revenue
     * @return bool
     */
    public function delete(User $user, Revenue $revenue)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the revenue.
     *
     * @param  App\User  $user
     * @param  App\Revenue  $revenue
     * @return bool
     */
    public function restore(User $user, Revenue $revenue)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the revenue.
     *
     * @param  App\User  $user
     * @param  App\Revenue  $revenue
     * @return bool
     */
    public function forceDelete(User $user, Revenue $revenue)
    {
        return false;
    }
}
