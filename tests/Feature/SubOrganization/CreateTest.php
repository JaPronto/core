<?php

namespace Tests\Feature\SubOrganization;

use App\SubOrganization;
use function GuzzleHttp\Psr7\str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends SubOrganizationTest
{
    /**
     * Test unauthenticated users can hit the create endpoint
     * @expected: true
     */
    public function test_unauthenticated_users_cannot_hit_the_create_endpoint()
    {
        // First we hit the create endpoint
        $this->create()
            // Then we assert status is 401, since we are not authenticated
            ->assertStatus(401)
            // Then assert the text Unauthenticated is present on response body
            ->assertSeeText('Unauthenticated');
    }

    /**
     * Test authenticated users can hit the create endpoint
     * @expected: false
     * Test authenticated users are allowed to create sub organizations
     * @expected: false
     */
    public function test_authenticated_users_are_not_allowed_to_create_sub_organizations()
    {
        // First we setup some auth headers
        $this->authenticated()
            // Then we hit the create endpoint
            ->create()
            // Then we assert response status is 403, since now we are authenticated, but not allowed to proceed with this action
            ->assertStatus(403)
            // Then we assert the text unauthorized is present on response body
            ->assertSeeText('unauthorized');
    }

    /**
     * Test authenticated admins can create sub organizations
     * @expected: true
     * Test validation blocks invalid create requests
     * @expected: true
     */
    public function test_authenticated_admins_can_create_sub_organizations_and_validation_works()
    {
        // First we setup some admin auth headers
        $this->authenticatedAdmin()
            // Then we hit the create endpoint
            ->create()
            // Then we assert status is 422, since now we are able to proceed with this action, but we haven't send valid params
            ->assertStatus(422)
            // Then we assert the response structure matches expected format
            ->assertJsonStructure([
               'errors' => [
                   'name',
                   'founded_at',
                   'description',
                   'country_id',
                   'organization_id'
               ]
            ]);
    }

    public function test_authenticated_admins_can_create_sub_organizations_successfully()
    {
        // First we make some fake data
        $subOrganization = $this->makeSubOrganization();

        // Then we setup some auth headers
        $this->authenticatedAdmin()
            // Then we sent fake data to create endpoint
            ->create($subOrganization->toArray())
            // Then we assert status is 201, witch means a new resource was created
            ->assertStatus(201)
            // Then we assert the sub_organization name is present on response body
            ->assertSeeText($subOrganization->name)
            // Then we assert the sub_organization description is present on response body
            ->assertSeeText($subOrganization->description)
            // Then we assert response body structure matches expected format
            ->assertJsonStructure([
               'data' => [
                   'id',
                   'name',
                   'slug',
                   'founded_at',
                   'description',
                   'country_id',
                   'organization_id'
               ]
            ]);

        // Then we assert database has the created data
        $this->assertDatabaseHas('sub_organizations', [
           'name' => $subOrganization->name,
           'description' => $subOrganization->description
        ]);
        // Then we assert that there is only 1 record witch represents our created sub_organization
        $this->assertCount(1, SubOrganization::get());
    }

    /**
     * Creates a new create sub organization request
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function create($data = [])
    {
        return $this->makePostRequest('store', $data);
    }
}
