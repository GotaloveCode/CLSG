<?php

namespace App\Policies;

use App\User;
use App\Connection;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConnectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any connection.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the connection.
     *
     * @param  App\User  $user
     * @param  App\Connection  $connection
     * @return bool
     */
    public function view(User $user, Connection $connection)
    {
        return false;
    }

    /**
     * Determine whether the user can create a connection.
     *
     * @param  App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the connection.
     *
     * @param  App\User  $user
     * @param  App\Connection  $connection
     * @return bool
     */
    public function update(User $user, Connection $connection)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the connection.
     *
     * @param  App\User  $user
     * @param  App\Connection  $connection
     * @return bool
     */
    public function delete(User $user, Connection $connection)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the connection.
     *
     * @param  App\User  $user
     * @param  App\Connection  $connection
     * @return bool
     */
    public function restore(User $user, Connection $connection)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the connection.
     *
     * @param  App\User  $user
     * @param  App\Connection  $connection
     * @return bool
     */
    public function forceDelete(User $user, Connection $connection)
    {
        return false;
    }
}
