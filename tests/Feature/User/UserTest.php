<?php

namespace Tests\Feature\User;


use App\User;
use Tests\DatabaseActiveTest;

abstract class UserTest extends DatabaseActiveTest
{
    public function createUser($atributes = [], $times = null)
    {
        return create(User::class, $atributes, $times);
    }
    
    public function makeUser($atributes = [], $times = null)
    {
        return make(User::class, $atributes, $times);
    }

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'users';
    }
}