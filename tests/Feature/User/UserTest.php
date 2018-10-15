<?php

namespace Tests\Feature\User;


use App\User;

trait UserTest
{
    public function createUser($atributes = [], $times = null)
    {
        return create(User::class, $atributes, $times);
    }
    
    public function makeUser($atributes = [], $times = null)
    {
        return make(User::class, $atributes, $times);
    }
}