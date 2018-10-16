<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyTest extends UserTest
{
    /**
     * Test unauthenticated users can hit the destroy endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_the_destroy_endpoint()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we hit the destroy endpoint
        $this->destroy($user->id)
            // Then we assert status is 401, since we are not authenticated
            ->assertStatus(401)
            // Then we assert the respose body contains the text Unauthenticated
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated users can hit the destroy endpoint
     * @expected: false
     */
    public function test_authenticated_users_cannot_hit_the_destroy_endpoint()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we setup common auth headers
        $this->authenticated()
            // Then we hit the destroy endpoint
            ->destroy($user->id)
            // Then we assert status is 403, witch means we are not authorized to proceed with this action
            ->assertStatus(403)
            // Then we assert unauthorized text is present on response body
            ->assertSeeText('unauthorized');
    }

    /**
     * Test users can delete itself account
     * @expected: false
     */
    public function test_users_can_delete_itself_account()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we set auth headers based on the created user
        $this->authenticated($user)
            // Then we hit the destroy endpoint
            ->destroy($user->id)
            // Then we assert status is 200, witch means we are able to delete the user
            ->assertStatus(200);

        // Finally we assert the user is soft-deleted on database
        $this->assertSoftDeleted('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    /**
     * Test admins can delete anyone
     * @expected: true
     */
    public function test_admins_can_delete_anyone()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we authenticate an admin user
        $this->authenticatedAdmin()
            // Then we hit the destroy endpoint
            ->destroy($user->id)
            // THen we assert status is 200, witch means we are able to delete the user
            ->assertStatus(200);

        // Finally we assert the user is soft-deleted on database
        $this->assertSoftDeleted('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    /**
     * Creates a new destroy request
     * @param $userId
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function destroy($userId)
    {
        return $this->makeDeleteRequest(['destroy', $userId]);
    }
}
