<?php

namespace App\Observers;


use App\User;
use Illuminate\Database\Eloquent\Model;

class UserObserver
{
    public function created(User $user)
    {
        $user->assignRole('user');
    }

    public function updating(User $user)
    {
        if ($user->isDirty('email')) {
            $user->setAttribute('email_verified_at', null);
        }
    }
}