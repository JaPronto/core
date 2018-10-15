<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\HasApiResource;

class CreateTest extends UserTest
{

    /**
     * Test if unauthenticated users can hit the create user endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_the_create_user_endpoint()
    {
        // First we create a create request
        $this->create()
            // Then we assert status is 401 because we are not sending any authentication headers
            ->assertStatus(401)
            // Then we assert response body have the word unauthenticated
            ->assertSeeText('Unauthenticated.');
    }

    /**
     * Test authenticated common users cannot hit the create user endpoint
     * @expected: false
     */
    public function test_authenticated_common_users_cannot_hit_the_create_user_endpoint()
    {
        // First we setup auth headers
        $this->authenticated()
            // Then we send the request to the api
            ->create()
            // Then we assert status is 403 since we are authenticated but not authorized to proceed with the action
            ->assertStatus(403)
            // Then we assert the response body has the word unauthorized
            ->assertSeeText('unauthorized');
    }

    /**
     *  Test authenticated admin users can hit the create user endpoint
     * @expected: true
     * Test create user endpoint validation
     * @expected: true
     */
    public function test_authenticated_admin_users_can_hit_the_create_user_endpoint()
    {
        // First we setup headers for an admin user
        $this->authenticatedAdmin()
            // Then we hit the create endpoint without any params
            ->create()
            // Then we assert status is 422 because we are able to proceed with the action, but haven't sent correct data
            ->assertStatus(422)
            // Then we assert the response matches expected format
            ->assertJsonStructure([
                'errors' => [
                    'name',
                    'email',
                    'password'
                ]
            ]);
    }

    /**
     *  Test authenticated admin users can hit the create user endpoint
     * @expected: true
     * Test create user endpoint works
     * @expected: true
     */
    public function test_authenticated_admin_users_can_hit_the_create_user_endpoint_and_successfully_create_a_user()
    {
        // First we make a test user
        $user = make('App\User')->toArray();
        // Then we added password to the user array
        $user['password'] = '16119900';
        // Then we added password_confirmation field for validation purposes
        $user['password_confirmation'] = $user['password'];

        // Then we authenticate with admin credentials
        $this->authenticatedAdmin()
            // Then we hit the create endpoint with the user data
            ->create($user)
            // Then we assert status is 201, witch means the user was successfully created
            ->assertStatus(201)
            // Then we assert user name is present on response body
            ->assertSeeText($user['name'])
            // Then we assert user email is present on response body
            ->assertSeeText($user['email'])
            // Then we assert response matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);

        // Then we check if the user was really added onto the database
        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email']
        ]);

        // Then we check if there are only 2 users (the admin witch created the user, and the created user)
        $this->assertCount(2, User::get());
    }

    public function create($data = [])
    {
        return $this->makePostRequest('store', $data);
    }
}
