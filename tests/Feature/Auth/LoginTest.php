<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->installPassport();
    }

    /**
     * Test if any user can hit the oauth/token endpoint
     * @expected: true
     */
    public function test_any_user_can_hit_the_login_endpoint()
    {
        $this->login()
            ->assertStatus(422);
    }

    /**
     * Test if any user can login on the /oauth/token endpoint
     * @expected: true
     * Test if authenticated user can get personal info
     * @expected: true
     */
    public function test_any_user_can_login_and_get_personal_info()
    {
        $password = '123456';
        $user = create(User::class, [
            'password' => bcrypt($password)
        ]);

        $response = $this->login([
            'email' => $user->email,
            'password' => $password
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token'
            ]);
    }

    public function login($data = [])
    {
        return $this->postJson('/login', $data);
    }
}
