<?php

namespace Tests\Feature\Organization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyTest extends OrganizationTest
{

    /**
     * Test unauthenticated users can hit the destroy endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_the_destroy_endpoint()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we hit the destroy endpoint
        $this->destroy($organization->slug)
            // Then we assert status is 401, because we are not authenticated
            ->assertStatus(401)
            // Then we assert the string Unauthenticated is present on response body
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated users are allowed to destroy organizations
     * @expected: false
     */
    public function test_authenticated_users_are_not_allowed_to_destroy_organizations()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we setup some auth headers
        $this->authenticated()
            // Then we hit the destroy endpoint
            ->destroy($organization->slug)
            // Then we assert status is 403, because we are authenticated but now allowed to destroy organizations
            ->assertStatus(403)
            // Then we assert the string unauthorized is present on response body
            ->assertSeeText('unauthorized');
    }

    public function test_authenticated_admins_are_allowed_to_destroy_organizations()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we setup some admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the destroy endpoint
            ->destroy($organization->slug)
            // Then we assert status is 200, witch means we have successfully deleted the organization
            ->assertStatus(200);

        // Finally we assert the organization was soft-deleted from database
        $this->assertSoftDeleted('organizations', [
            'id' => $organization['id']
        ]);
    }

    /**
     * Creates a new destroy request
     * @param $organizationSlug
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function destroy($organizationSlug)
    {
        return $this->makeDeleteRequest(['destroy', $organizationSlug]);
    }
}
