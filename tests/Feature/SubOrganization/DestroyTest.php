<?php

namespace Tests\Feature\SubOrganization;


class DestroyTest extends SubOrganizationTest
{
    /**
     * Test unauthenticated users can hit the destroy endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_the_destroy_endpoint()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we hit the destroy endpoint
        $this->destroy($organization->slug)
            // Then we assert the status is 401, because we are not authenticated
            ->assertStatus(401)
            // Then we assert the response body contains the Unauthenticated string
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated users are allowed to destroy sub organizations
     * @expected: false
     */
    public function test_authenticated_users_are_not_allowed_to_destroy_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we setup some auth headers
        $this->authenticated()
            // Then we hit the destroy endpoint
            ->destroy($organization->slug)
            // Then we assert the response status is 403, because we are not allowed to destroy sub organizations
            ->assertStatus(403)
            // Then we assert the response body contains the unauthorized string
            ->assertSeeText('unauthorized');
    }

    /**
     * Test authenticated admins can destroy sub organizations
     * @expected: true
     */
    public function test_authenticated_admins_are_allowed_to_destroy_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we setup some admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the destroy endpoint
            ->destroy($organization->slug)
            // Then we assert status is 200, witch means we have successfully deleted the sub organization
            ->assertStatus(200);

        // Then we assert database record was really soft-deleted
        $this->assertSoftDeleted('sub_organizations', [
           'id' => $organization->id
        ]);
    }

    /**
     * Creates a destroy sub organization request
     * @param $subOrganizationSlug
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function destroy($subOrganizationSlug)
    {
        return $this->makeDeleteRequest(['destroy', $subOrganizationSlug]);
    }
}