<?php

namespace App\Policies;

use App\User;
use App\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any service.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the service.
     *
     * @param  App\User  $user
     * @param  App\Service  $service
     * @return bool
     */
    public function view(User $user, Service $service)
    {
        return false;
    }

    /**
     * Determine whether the user can create a service.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param  App\User  $user
     * @param  App\Service  $service
     * @return bool
     */
    public function update(User $user, Service $service)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param  App\User  $user
     * @param  App\Service  $service
     * @return bool
     */
    public function delete(User $user, Service $service)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the service.
     *
     * @param  App\User  $user
     * @param  App\Service  $service
     * @return bool
     */
    public function restore(User $user, Service $service)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the service.
     *
     * @param  App\User  $user
     * @param  App\Service  $service
     * @return bool
     */
    public function forceDelete(User $user, Service $service)
    {
        return false;
    }
}
