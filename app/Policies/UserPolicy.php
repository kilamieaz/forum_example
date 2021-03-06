<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the signedInUser.
     *
     * @param  \App\User  $user
     * @param  \App\User  $signedInUser
     * @return mixed
     */
    public function view(User $user, User $signedInUser)
    {
        //
    }

    /**
     * Determine whether the user can create signedInUsers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the signedInUser.
     *
     * @param  \App\User  $user
     * @param  \App\User  $signedInUser
     * @return mixed
     */
    public function update(User $user, User $signedInUser)
    {
        return $signedInUser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the signedInUser.
     *
     * @param  \App\User  $user
     * @param  \App\User  $signedInUser
     * @return mixed
     */
    public function delete(User $user, User $signedInUser)
    {
        //
    }

    /**
     * Determine whether the user can restore the signedInUser.
     *
     * @param  \App\User  $user
     * @param  \App\User  $signedInUser
     * @return mixed
     */
    public function restore(User $user, User $signedInUser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the signedInUser.
     *
     * @param  \App\User  $user
     * @param  \App\User  $signedInUser
     * @return mixed
     */
    public function forceDelete(User $user, User $signedInUser)
    {
        //
    }
}
