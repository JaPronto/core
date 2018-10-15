<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authenticated($user = null)
    {
        Passport::actingAs($user ?: create(User::class));

        return $this;
    }

    public function authenticatedAdmin($user = null)
    {
        $user = $user ?: create(User::class);

        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }

        Passport::actingAs($user);

        return $this;
    }
}
