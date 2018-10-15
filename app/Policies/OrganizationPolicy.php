<?php

namespace App\Policies;

use App\User;
use App\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) return true;
    }

    /**
     * Determine whether the user can view the organization.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the organization.
     *
     * @param  \App\User $user
     * @param Organization $organization
     * @return mixed
     */
    public function show(User $user, Organization $organization)
    {
        return true;
    }

    /**
     * Determine whether the user can create organizations.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the organization.
     *
     * @param  \App\User $user
     * @param  \App\Organization $organization
     * @return mixed
     */
    public function update(User $user, Organization $organization)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the organization.
     *
     * @param  \App\User $user
     * @param  \App\Organization $organization
     * @return mixed
     */
    public function delete(User $user, Organization $organization)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the organization.
     *
     * @param  \App\User $user
     * @param  \App\Organization $organization
     * @return mixed
     */
    public function restore(User $user, Organization $organization)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the organization.
     *
     * @param  \App\User $user
     * @param  \App\Organization $organization
     * @return mixed
     */
    public function forceDelete(User $user, Organization $organization)
    {
        return false;
    }
}
