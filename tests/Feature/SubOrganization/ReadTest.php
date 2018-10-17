<?php

namespace Tests\Feature\SubOrganization;


class ReadTest extends SubOrganizationTest
{
    /**
     * Test unauthenticated users can read sub organizations
     * @expected: true
     */
    public function test_unauthenticated_users_can_read_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we hit the read endpoint
        $this->read()
            // Then we assert status is 200, witch means we can access to this resource
            ->assertStatus(200)
            // Then we assert the organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response structure matches expected format
            ->assertPaginationResource();
    }

    /**
     * Test authenticated users can read sub organizations
     */
    public function test_authenticated_users_can_read_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we setup some auth headers
        $this->authenticated()
            // Then we hit the read endpoint
            ->read()
            // Then we assert status is 200, witch means we can access to this resource
            ->assertStatus(200)
            // Then we assert the organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response structure matches expected format
            ->assertPaginationResource();
    }

    /**
     * Test authenticated admins can read sub organization
     * @expected: true
     */
    public function test_authenticated_admins_can_read_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we setup some admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the read endpoint
            ->read()
            // Then we assert status is 200, witch means we can access to this resource
            ->assertStatus(200)
            // Then we assert the organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response structure matches expected format
            ->assertPaginationResource();
    }

    /**
     * Creates a new read request
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function read()
    {
        return $this->makeGetRequest('index');
    }
}