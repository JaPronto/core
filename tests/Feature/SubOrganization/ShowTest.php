<?php

namespace Tests\Feature\SubOrganization;


class ShowTest extends SubOrganizationTest
{
    /**
     * Test unauthenticated users can show sub organizations
     * @expected: true
     */
    public function test_unauthenticated_users_can_show_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we hit the show endpoint
        $this->show($organization->slug)
            // Then we assert status is 200, witch means we can access to this resource
            ->assertStatus(200)
            // Then we assert the organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response structure matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'founded_at',
                    'description',
                    'country_id',
                    'organization_id',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Test authenticated users can show sub organizations
     */
    public function test_authenticated_users_can_show_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we setup some auth headers
        $this->authenticated()
            // Then we hit the show endpoint
            ->show($organization->slug)
            // Then we assert status is 200, witch means we can access to this resource
            ->assertStatus(200)
            // Then we assert the organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response structure matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'founded_at',
                    'description',
                    'country_id',
                    'organization_id',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Test authenticated admins can show sub organization
     * @expected: true
     */
    public function test_authenticated_admins_can_show_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we setup some admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the show endpoint
            ->show($organization->slug)
            // Then we assert status is 200, witch means we can access to this resource
            ->assertStatus(200)
            // Then we assert the organization name is present on response body
            ->assertSeeText($organization->name)
            // Then we assert the organization description is present on response body
            ->assertSeeText($organization->description)
            // Then we assert the response structure matches expected format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'founded_at',
                    'description',
                    'country_id',
                    'organization_id',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Creates a new show request
     * @param $subOrganizationSlug
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function show($subOrganizationSlug)
    {
        return $this->makeGetRequest(['show', $subOrganizationSlug]);
    }
}