<?php

namespace Tests\Feature\Country;

use App\Country;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\HasApiResource;

class CreateTest extends TestCase
{
    use HasApiResource, DatabaseMigrations, DatabaseTransactions, CountryTest;

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'country';
    }


    /**
     * Check if unauthenticated users can hit the create country endpoint
     * @expected: false
     */
    public function test_unauthenticated_cannot_hit_create_endpoint()
    {
        // First we instantiate a request to create country endpoint
        $response = $this->create();

        // Then we assert the response status is 401
        // Because we are not sending any authentication headers
        $response->assertStatus(401);
    }

    /**
     *  Check if authenticated users can hit the create country endpoint
     * @expected: true
     *  Check if the create country endpoint validation allow empty requests
     * @expected: false
     */
    public function test_authenticated_common_user_can_hit_create_endpoint()
    {
        // First we authenticate the user with passport
        // Then we instantiate a new create request for countries endpoint
        $response = $this->authenticated()->create();

        // Then we assert status is 403
        // Because now we are sending authentication headers
        // But we are not allowed to run this action
        $response->assertStatus(403)
            // Then we assert errors structure matches expected
            ->assertSeeText('unauthorized');
    }

    /**
     *  Check if authenticated users can hit the create country endpoint
     * @expected: true
     *  Check if the create country endpoint validation allow empty requests
     * @expected: false
     */
    public function test_authenticated_admin_user_can_hit_create_endpoint()
    {
        // First we authenticate the user with passport
        // Then we instantiate a new create request for countries endpoint
        $response = $this->authenticatedAdmin()->create();

        // Then we assert status is 422
        // Because now we are sending authentication headers
        // But not sending any data, the validation should block us from proceed
        $response->assertStatus(422)
            // Then we assert errors structure matches expected
            ->assertJsonStructure([
                'errors' => [
                    'name',
                    'code'
                ]
            ]);
    }

    /**
     * Test if authenticated users can hit the create endpoint
     * @expected: true
     * Test if validation block us from sending requests with correct params
     * @expected: false
     * Test if country is successfully created when sending auth headers and correct params
     * @expected: true
     */
    public function test_authenticated_admin_user_can_successfully_create_country()
    {
        // First we create a test country
        $country = $this->makeCountry();
        // Then we create a authenticated request for create country endpoint
        $response = $this->authenticatedAdmin()->create($country->toArray());

        // Then we assert that response has status 201 that means resource created
        $response->assertStatus(201)
            // Then we assert the country name is on the response body
            ->assertSeeText($country['name'])
            // Then we assert the country code is on the response body
            ->assertSeeText($country['code'])
            // Then we assert the response structure matches expected resource format
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'code',
                    'created_at',
                    'updated_at'
                ]
            ]);

        // Then we assert the country is persisted on database
        $this->assertDatabaseHas('countries', $country->toArray());
        // Finally we assert that there is only 1 country created per request
        $this->assertCount(1, Country::get());
    }

    /**
     * Create a request for the create country endpoint
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function create($data = [], $headers = [])
    {
        return $this->makePostRequest('store', $data, $headers);
    }
}
