<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param \App\Models\User $user
     * @param string           $ability
     *
     * @return void|bool
     */
    public function before(?User $user, $ability)
    {
        if (auth()->guest()) {
            return false;
        }

    }

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Contact $contact)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Contact $contact)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Contact $contact)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Contact $contact)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Contact $contact)
    {
        return $user->is_admin;
    }
}
