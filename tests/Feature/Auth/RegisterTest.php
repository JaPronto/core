<?php

namespace Tests\Feature\Auth;

use App\User;

class RegisterTest extends AuthTest
{

    /**
     * Test if guest users can hit the register endpoint
     * @expected: true
     * Test if validation on register endpoint works and block us
     * @expected: true
     */
    public function test_can_hit_register_endpoint()
    {
        // We hit the register endpoint
        $this->register()
            // And assert status is 422 since we have not passed any parameters
            ->assertStatus(422);
    }

    /**
     * Test if any user can register itself
     */
    public function test_can_register()
    {
        $password = '123456';
        $user = make(User::class)->toArray();
        $user['password'] = $password;
        $user['password_confirmation'] = $password;

        $this->register($user)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token'
            ]);
    }

    public function register($data = [])
    {
        return $this->postJson('/register', $data);
    }
}
