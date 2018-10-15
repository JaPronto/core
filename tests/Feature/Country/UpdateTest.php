<?php

namespace Tests\Feature\Country;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\HasApiResource;

class UpdateTest extends TestCase
{
    use DatabaseMigrations, HasApiResource, CountryTest;

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'country';
    }

    /**
     * Test if unauthenticated users can hit the update endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_the_update_endpoint()
    {
        // First we create a test country
        $country = $this->createCountry();

        // Then we assert it was successfully added into the database
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we create a update request with no auth headers
        $this->update($country->code, [])
            // Finally we assert status is 401 because unauthenticated users should not be able to hit this endpoint
            ->assertStatus(401);
    }

    /**
     * Test if authenticated users can hit the update endpoint
     * @expected: true
     * Test if can update countries with empty params
     * @expected: false
     */
    public function test_authenticated_common_users_can_hit_the_update_endpoint()
    {
        // First we create a test country
        $country = $this->createCountry();

        // Then we check if it was successfully added into the database
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we create an update request with auth headers and empty params
        $this->authenticated()->update($country->code, [])
            // We assert status is 403, because now we are authenticated, but we are not able to execute this action
            ->assertStatus(403)
            // Then we assert we receive the message unauthorized
            ->assertSeeText('unauthorized');
    }

    /**
     * Test if authenticated users can hit the update endpoint
     * @expected: true
     * Test if can update countries with empty params
     * @expected: false
     */
    public function test_authenticated_admin_users_can_hit_the_update_endpoint()
    {
        // First we create a test country
        $country = $this->createCountry();

        // Then we check if it was successfully added into the database
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we create an update request with auth headers and empty params
        $this->authenticatedAdmin()->update($country->code, [])
            // We assert status is 422, because now we are authenticated, but request params are invalid
            ->assertStatus(422)
            // Then we assert errors structure matches expected
            ->assertJsonStructure([
                'errors' => [
                    'name',
                    'code'
                ]
            ]);
    }

    /**
     * Test authenticated users can successfully update countries
     * @expected: true
     */
    public function test_authenticated_admin_users_can_update_countries()
    {
        // First we create a test country
        $country = $this->createCountry();

        // Then we assert it was successfully inserted into database
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we future data array
        $newCountry = collect([
            'name' => 'test name',
            'code' => 'TEST_CODE'
        ]);

        // Then we send the update request with $newCountry params
        $response = $this->authenticatedAdmin()->update($country->code, $newCountry->toArray());

        // Then we assert if country was successfully updated
        $response->assertStatus(200)
            // Check if new country name is present on response body
            ->assertSeeText($newCountry->get('name'))
            // Check if new country code is present on response body
            ->assertSeeText($newCountry->get('code'))
            // Check if response structure matches expected
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'code',
                    'created_at',
                    'updated_at'
                ]
            ]);

        // Finally we assert database has updated correctly the country with $newCountry info
        $this->assertDatabaseHas('countries', [
            'id' => $country->id,
            'name' => $newCountry->get('name'),
            'code' => $newCountry->get('code'),
        ]);
    }


    /**
     * Creates a new update request
     * @param $countryCode
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function update($countryCode, $data = [])
    {
        return $this->makePatchRequest(['update', $countryCode], $data);
    }
}
