<?php

namespace App\Policies;

use App\User;
use App\SubOrganization;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubOrganizationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) return true;
    }

    /**
     * Determine whether the user can view the sub organization.
     *
     * @param  \App\User  $user
     * @param  \App\SubOrganization  $subOrganization
     * @return mixed
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can show the sub organization.
     *
     * @param  \App\User  $user
     * @param  \App\SubOrganization  $subOrganization
     * @return mixed
     */
    public function show(User $user, SubOrganization $subOrganization)
    {
        return true;
    }

    /**
     * Determine whether the user can create sub organizations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the sub organization.
     *
     * @param  \App\User  $user
     * @param  \App\SubOrganization  $subOrganization
     * @return mixed
     */
    public function update(User $user, SubOrganization $subOrganization)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the sub organization.
     *
     * @param  \App\User  $user
     * @param  \App\SubOrganization  $subOrganization
     * @return mixed
     */
    public function delete(User $user, SubOrganization $subOrganization)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the sub organization.
     *
     * @param  \App\User  $user
     * @param  \App\SubOrganization  $subOrganization
     * @return mixed
     */
    public function restore(User $user, SubOrganization $subOrganization)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the sub organization.
     *
     * @param  \App\User  $user
     * @param  \App\SubOrganization  $subOrganization
     * @return mixed
     */
    public function forceDelete(User $user, SubOrganization $subOrganization)
    {
        return false;
    }
}
