<?php

namespace Tests\Feature\Organization;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends OrganizationTest
{
    /**
     * Test unauthenticated users can hit the create organization endpoint
     * @expected: false
     */
    public function test_unauthenticated_cannot_hit_the_create_organization_endpoint()
    {
        // First we hit the create endpoint
        $this->create()
            // Then we assert status is 401 since we are not authenticated
            ->assertStatus(401)
            // Then we assert the text Unauthenticated is present on response body
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated common users are allowed to hit the create organization endpoint
     * @expected: false
     */
    public function test_authenticated_users_are_not_allowed_to_create_organizations()
    {
        // First we setup some basic auth headers
        $this->authenticated()
            // Then we hit the create endpoint
            ->create()
            // Then we assert status is 403, because now we are authenticated, but now allowed to do this action
            ->assertStatus(403)
            // Then we assert the text unauthorized is present on response body
            ->assertSeeText('unauthorized');
    }

    /**
     * Test admin users can hit the create organizations endpoint
     * @expected: true
     * Test validation block us when sending incorrect params
     * @expected: true
     */
    public function test_admins_can_create_organizations_but_should_send_correct_params()
    {
        // First we setup some admin auth
        $this->authenticatedAdmin()
            // Then we hit the create endpoint
            ->create()
            // Then we assert status is 422, because we are authenticated and allowed to do this action, but we sen't wrong data to the controller
            ->assertStatus(422)
            // Then we assert the response body matches expected format
            ->assertJsonStructure([
                'errors' => [
                    'name',
                    'founded_at',
                    'country_id',
                    'description',
                    'image'
                ]
            ]);
    }

    /**
     * Test admins can create organizations
     * @expected: true
     * Test image is correctly uploaded and saved on database
     * @expected: true
     */
    public function test_admins_can_create_organizations_when_correct_params_are_sent()
    {
        // First we fake the storage public
        Storage::fake('public');

        // Then we create a test organization with faked data and a faked image
        $organization = $this->makeOrganization([
            'image' => UploadedFile::fake()->image('organization.jpg')
        ]);

        // Then we hit the create endpoint with faked data and image
        $response = $this->authenticatedAdmin()
            ->create($organization->toArray());

        // Then we assert response status is 201, witch means a organization was created
        $response->assertStatus(201)
            ->assertSeeText($organization->name)
            ->assertSeeText($organization->description);

        // Then we get the uploaded image name for database testing
        $imageName = basename(json_decode($response->getContent())->data->image);

        // Then we assert the record was successfully added to database
        $this->assertDatabaseHas('organizations', [
            'name' => $organization['name'],
            'description' => $organization['description'],
            'country_id' => $organization['country_id'],
            'image' => $imageName
        ]);

        // Then we assert storage has received correct image
        Storage::disk('public')->assertExists('organizations/' . $imageName);
    }

    /**
     * Creates a new create organization request
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function create($data = [])
    {
        return $this->makePostRequest('store', $data);
    }
}
