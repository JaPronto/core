<?php

namespace Tests\Feature\Organization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends OrganizationTest
{
    /**
     * Test unauthenticated users can show organization info
     * @expected: true
     */
    public function test_unauthenticated_users_can_show_organizations_info()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we hit the show endpoint using the created organization slug
        $this->show($organization->slug)
            // Then we assert status is 200, because anyone can read organization info
            ->assertStatus(200)
            // Then we assert the created organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the created organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert response body matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'founded_at',
                    'country_id',
                    'description',
                    'image',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Test authenticated users can show organization info
     * @expected: true
     */
    public function test_authenticated_users_can_show_organizations_info()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we setup some auth headers
        $this->authenticated()
            // Then we hit the show endpoint using the created organization slug
            ->show($organization->slug)
            // Then we assert status is 200, because anyone can read organization info
            ->assertStatus(200)
            // Then we assert the created organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the created organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert response body matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'founded_at',
                    'country_id',
                    'description',
                    'image',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Test authenticated admins can show organizations info
     * @expected: true
     */
    public function test_authenticated_admin_users_can_show_organizations_info()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we setup some admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the show endpoint using the created organization slug
            ->show($organization->slug)
            // Then we assert status is 200, because anyone can read organization info
            ->assertStatus(200)
            // Then we assert the created organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the created organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert response body matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'founded_at',
                    'country_id',
                    'description',
                    'image',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Creates a new show request
     * @param $organizationSlug
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function show($organizationSlug)
    {
        return $this->makeGetRequest(['show', $organizationSlug]);
    }
}
