<?php

namespace Tests\Feature\SubOrganization;


class UpdateTest extends SubOrganizationTest
{

    /**
     * Test unauthenticated users can hit the update endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_update_endpoint()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();

        // Then we hit the update endpoint
        $this->update($organization->slug)
            // Then we assert status is 401, because we are not authenticated
            ->assertStatus(401)
            // Then we assert the response body has the text Unauthenticated
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated users are allowed to update sub organizations
     * @expected: false
     */
    public function test_authenticated_users_are_not_allowed_to_update_sub_organizations()
    {
        // First we create a test sub_organization
        $organization = $this->createSubOrganization();

        // Then we setup some auth headers
        $this->authenticated()
            // Then we hit the update endpoint
            ->update($organization->slug)
            // Then we assert status is 403, because now we are authenticated, but not allowed to update sub organizations
            ->assertStatus(403)
            // Then we assert the text unauthorized is present on response body
            ->assertSeeText('unauthorized');
    }

    /**
     * Test authenticated admins are allowed to update sub organizations
     * @expected: true
     */
    public function test_authenticated_admins_are_allowed_to_update_sub_organizations()
    {
        // First we create a test sub organization
        $organization = $this->createSubOrganization();
        // Then we create fake data to update the sub organization
        $newOrganization = [
            'name' => 'test name',
            'description' => 'test description'
        ];

        // Then we setup some admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the update params with fake data
            ->update($organization->slug, $newOrganization)
            // Then we assert status is 200, witch means we has successfully updated the sub organization
            ->assertStatus(200)
            // Then we assert the new organization name is present on response body
            ->assertSeeText($newOrganization['name'])
            // Then we assert the new organization description is present on response body
            ->assertSeeText($newOrganization['description'])
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

        // Then we assert the record was updated on database
        $this->assertDatabaseHas('sub_organizations', [
           'id' => $organization->id,
           'name' => $newOrganization['name'],
           'description' => $newOrganization['description']
        ]);
    }

    /**
     * Creates a new update sub_organization request
     * @param $subOrganizationSlug
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function update($subOrganizationSlug, $data = [])
    {
        return $this->makePatchRequest(['update', $subOrganizationSlug], $data);
    }
}