<?php

namespace App\Policies;

use App\User;
use App\Staff;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any staff.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the staff.
     *
     * @param  App\User  $user
     * @param  App\Staff  $staff
     * @return bool
     */
    public function view(User $user, Staff $staff)
    {
        return false;
    }

    /**
     * Determine whether the user can create a staff.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the staff.
     *
     * @param  App\User  $user
     * @param  App\Staff  $staff
     * @return bool
     */
    public function update(User $user, Staff $staff)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the staff.
     *
     * @param  App\User  $user
     * @param  App\Staff  $staff
     * @return bool
     */
    public function delete(User $user, Staff $staff)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the staff.
     *
     * @param  App\User  $user
     * @param  App\Staff  $staff
     * @return bool
     */
    public function restore(User $user, Staff $staff)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the staff.
     *
     * @param  App\User  $user
     * @param  App\Staff  $staff
     * @return bool
     */
    public function forceDelete(User $user, Staff $staff)
    {
        return false;
    }
}
