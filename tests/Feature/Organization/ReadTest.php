<?php

namespace Tests\Feature\Organization;

use App\Organization;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadTest extends OrganizationTest
{
    /**
     * Test unauthenticated users can read organizations
     * @expected: true
     */
    public function test_unauthenticated_users_can_read_organizations_info()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we hit the read endpoint
        $this->read()
            // Then we assert status is 200, witch means we are able to read organizations info
            ->assertStatus(200)
            // Then we assert the created organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the created organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response format matches a pagination resource
            ->assertPaginationResource();
    }

    /**
     * Test authenticated users can read organizations
     * @expected: true
     */
    public function test_authenticated_users_can_read_organizations_info()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we setup some user auth headers
        $this->authenticated()
            // Then we hit the read endpoint
            ->read()
            // Then we assert status is 200, witch means we are able to read organizations info
            ->assertStatus(200)
            // Then we assert the created organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the created organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response format matches a pagination resource
            ->assertPaginationResource();
    }

    public function test_authenticated_admins_users_can_read_organizations_info()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we setup some auth headers
        $this->authenticatedAdmin()
            // Then we hit the read endpoint
            ->read()
            // Then we assert status is 200, witch means we are able to read organizations info
            ->assertStatus(200)
            // Then we assert the created organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the created organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response format matches a pagination resource
            ->assertPaginationResource();
    }

    public function read()
    {
        return $this->makeGetRequest('index');
    }
}
