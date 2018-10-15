<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\HasApiResource;

class ReadTest extends UserTest
{
    /**
     * Test if unauthenticated users can read users
     * @expected: false
     */
    public function test_unauthenticated_user_cannot_hit_the_read_users_endpoint()
    {
        // First we hit the read users endpoint
        $this->read()
            // Then we assert status is 401, since we are not authenticated
            ->assertStatus(401)
            // Then we assert the text Unauthenticated is on response body
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test if authenticated users are able to read users
     * @expected: false
     */
    public function test_authenticated_users_cannot_hit_the_read_users_endpoint()
    {
        // First we setup common user auth headers
        $this->authenticated()
            // Then we hit the read endpoint
            ->read()
            // Then we assert status is 403, becase we are not able to read users
            ->assertStatus(403)
            // Then we assert response body has the unauthorized text
            ->assertSeeText('unauthorized');
    }

    /**
     * Test if authenticated admins can hit the read users endpoint
     * @expected: false
     */
    public function test_authenticated_admins_can_hit_the_read_users_endpoint()
    {
        // First we create a test user
        $user = create(User::class);

        // Then we set admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the read users endpoint
            ->read()
            // Then we assert status is 200, witch means we are able to read users
            ->assertStatus(200)
            // Then we assert user name is on the response body
            ->assertSeeText($user->name)
            // Then we assert user email is on the response body
            ->assertSeeText($user->email)
            // Then we assert the response structure matches expected format
            ->assertPaginationResource();
    }

    /**
     * Create a new read request
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function read()
    {
        return $this->makeGetRequest('index');
    }
}
