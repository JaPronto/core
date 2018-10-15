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
        Passport::actingAs(create($user ?: User::class));

        return $this;
    }
}
