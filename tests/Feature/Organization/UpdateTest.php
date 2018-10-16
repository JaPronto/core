<?php

namespace Tests\Feature\Organization;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends OrganizationTest
{
    /**
     * Test unauthenticated users can hit the update endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_the_update_endpoint()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we hit the update endpoint
        $this->update($organization->slug)
            // Then we assert status is 401, since we are not authenticated
            ->assertStatus(401)
            // Then we assert the text Unauthenticated is present on response body
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated users are authorized to update organizations
     * @expected: false
     */
    public function test_authenticated_users_are_not_authorized_to_update_organizations()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we setup some auth headers
        $this->authenticated()
            // Then we hit the update endpoint
            ->update($organization->slug)
            // Then we assert status is 403, since we are now authenticated, but now allowed to do this action
            ->assertStatus(403)
            // Then we assert the text unauthorized is present on response body
            ->assertSeeText('unauthorized');
    }

    /**
     * Test authenticated admins can update organizations
     * @expected: true
     * Test validation block us from sending invalid data
     * @expected: true
     */
    public function test_authenticated_admins_are_authorized_to_update_organizations_but_should_send_correct_data()
    {
        // First we create a test organization
        $organization = $this->createOrganization();

        // Then we setup some auth headers
        $this->authenticatedAdmin()
            // Then we hit the update endpoint
            ->update($organization->slug, ['image' => 'lorem'])
            // Then we assert status is 422, since we sent invalid data to request
            ->assertStatus(422)
            // Then we assert response body matches expected format
            ->assertJsonStructure([
                'errors' => [
                    'image',
                ]
            ]);
    }

    /**
     * Test authenticated admins are able to update organization data
     * @expected: true
     * Test validation let us pass when sending correct data
     * @expected: true
     */
    public function test_authenticated_admins_are_authorized_to_update_organizations_when_sent_correct_data()
    {
        // First we create a test organization
        $organization = $this->createOrganization();
        // Then we create a new info array
        $newOrganization = [
            'name' => 'test name',
            'description' => 'test description'
        ];

        // Then we setup some auth headers
        $this->authenticatedAdmin()
            // Then we hit the update endpoint with the new info data
            ->update($organization->slug, $newOrganization)
            // Then we assert status is 200, witch means we successfully updated the organization info
            ->assertStatus(200)
            // Then we assert the new organization name is present on response body
            ->assertSeeText($newOrganization['name'])
            // Then we assert the new organization description is present on response body
            ->assertSeeText($newOrganization['description'])
            // Then we assert the response body matches expected format
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

        $this->assertDatabaseHas('organizations', $newOrganization);
    }

    public function test_authenticated_admins_can_update_organization_image()
    {
        // First we fake the public storage disk
        Storage::fake('public');

        // Then we create a test organization
        $organization = $this->createOrganization();
        // Then we create a new info array
        $newOrganization = [
            'name' => 'test name',
            'description' => 'test description',
            'image' => UploadedFile::fake()->image('new-organization.jpg')
        ];

        // Then we setup some auth headers
        $response = $this->authenticatedAdmin()
            // Then we hit the update endpoint with the new info data
            ->update($organization->slug, $newOrganization);

        $response
            // Then we assert status is 200, witch means we successfully updated the organization info
            ->assertStatus(200)
            // Then we assert the new organization name is present on response body
            ->assertSeeText($newOrganization['name'])
            // Then we assert the new organization description is present on response body
            ->assertSeeText($newOrganization['description'])
            // Then we assert the response body matches expected format
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

        // Then we get the new uploaded image name
        $imageName = basename(json_decode((string)$response->getContent())->data->image);

        // Then we add it to the new info array
        $newOrganization['image'] = $imageName;

        // And assert database has updated the info
        $this->assertDatabaseHas('organizations', $newOrganization);

        // And assert the file was successfully added to public disk
        Storage::disk('public')->assertExists('organizations/' . $imageName);
    }

    /**
     * Creates a new update request
     * @param $organizationSlug
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function update($organizationSlug, $data = [])
    {
        return $this->makePatchRequest(['update', $organizationSlug], $data);
    }
}
