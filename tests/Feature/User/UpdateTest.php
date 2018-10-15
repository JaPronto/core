<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\HasApiResource;

class UpdateTest extends TestCase
{
    use DatabaseMigrations, UserTest, HasApiResource;

    protected function setUp()
    {
        parent::setUp();

        $this->installPassport();
    }

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'user';
    }

    /**
     * Test unauthenticated users can hit the update endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_the_update_endpoint()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we hit the update endpoint
        $this->update($user->id)
            // Then we assert status is 401, because we are not authenticated
            ->assertStatus(401)
            // Then we assert the response body has the Unauthenticated string
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated common users can hit the update endpoint
     * @expected: false
     */
    public function test_authenticated_common_users_cannot_hit_the_update_endpoint()
    {
        // First we create a test user
        $user = $this->createUser();

        // Then we setup common auth headers
        $this->authenticated()
            // Then we hit the update endpoint
            ->update($user->id)
            // Then we assert status is 403 (unauthorized), since we are not acting as admins and have no permission to proceed with this action
            ->assertStatus(403)
            // Then we assert the text Unauthorized is on response body
            ->assertSeeText('unauthorized');
    }

    public function test_authenticated_admin_users_can_hit_the_update_endpoint()
    {
        // First we create a test user
        $user = $this->createUser();
        // Then we create for-update data
        $newUser = [
          'name' => 'jhon doe',
          'email' => 'jhon@doe.com'
        ];

        // Then we setup admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the update endpoint
            ->update($user->id, $newUser)
            // Then we assert status is 200, witch means the resource was successfully updated
            ->assertStatus(200)
            // Then we assert the new name is present on response body
            ->assertSeeText($newUser['name'])
            // Then we assert the new email is present on response body
            ->assertSeeText($newUser['email'])
            // Then we assert the response body matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $newUser['email_verified_at'] = null;
        // Then we assert the user was really updated, and email_verified_at was changed to null
        $this->assertDatabaseHas('users', $newUser);
    }

    /**
     * Creates a new update request
     * @param $userId
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function update($userId, $data = [])
    {
        return $this->makePatchRequest(['update', $userId], $data);
    }
}
