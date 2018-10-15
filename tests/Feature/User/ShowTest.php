<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends UserTest
{
    /**
     * Test unauthenticated users can hit the show endpoint
     * @expected: false
     */
    public function test_unauthenticated_user_cannot_hit_the_show_endpoint()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we hit the show endpoint
        $this->show($user->id)
            // Then we assert status is 401, since we are not authenticated
            ->assertStatus(401)
            // Then we assert the text Unauthenticated is present on response body
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated common users can hit the show endpoint
     * @expected: false
     */
    public function test_authenticated_common_users_cannot_hit_the_show_endpoint()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we setup some auth headers
        $this->authenticated()
            // Then we hit the show endpoint
            ->show($user->id)
            // Then we assert status is 403, because we are authenticated but have not permission to view other users info
            ->assertStatus(403)
            // Then we assert text unauthorized is present on response body
            ->assertSeeText('unauthorized');
    }

    /**
     * Test user can read itself info
     * @expected: true
     */
    public function test_user_can_read_itself_info()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we setup headers from the created user
        $this->authenticated($user)
            // Then we hit the show endpoint
            ->show($user->id)
            // Then we assert status is 200, because the requester user is the owner of the info
            ->assertStatus(200)
            // Then we assert the user name is present on response body
            ->assertSeeText($user->name)
            // Then we assert the user email is present on response body
            ->assertSeeText($user->email)
            // Then we assert response body structure matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_admin_can_read_anyone_info()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we setup some admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the show endpoint
            ->show($user->id)
            // Then we assert status is 200, because the requester user is the owner of the info
            ->assertStatus(200)
            // Then we assert the user name is present on response body
            ->assertSeeText($user->name)
            // Then we assert the user email is present on response body
            ->assertSeeText($user->email)
            // Then we assert response body structure matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Creates a new show request
     * @param $userId
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function show($userId)
    {
        return $this->makeGetRequest(['show', $userId]);
    }
}
