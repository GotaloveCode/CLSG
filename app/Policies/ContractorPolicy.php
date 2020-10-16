<?php

namespace App\Policies;

use App\User;
use App\Contractor;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any contractor.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the contractor.
     *
     * @param  App\User  $user
     * @param  App\Contractor  $contractor
     * @return bool
     */
    public function view(User $user, Contractor $contractor)
    {
        return false;
    }

    /**
     * Determine whether the user can create a contractor.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the contractor.
     *
     * @param  App\User  $user
     * @param  App\Contractor  $contractor
     * @return bool
     */
    public function update(User $user, Contractor $contractor)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the contractor.
     *
     * @param  App\User  $user
     * @param  App\Contractor  $contractor
     * @return bool
     */
    public function delete(User $user, Contractor $contractor)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the contractor.
     *
     * @param  App\User  $user
     * @param  App\Contractor  $contractor
     * @return bool
     */
    public function restore(User $user, Contractor $contractor)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the contractor.
     *
     * @param  App\User  $user
     * @param  App\Contractor  $contractor
     * @return bool
     */
    public function forceDelete(User $user, Contractor $contractor)
    {
        return false;
    }
}
