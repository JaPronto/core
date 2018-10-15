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
}