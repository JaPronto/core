<?php

namespace Tests\Feature\Country;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\HasApiResource;

class DestroyTest extends TestCase
{
    use HasApiResource, DatabaseMigrations, CountryTest;

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'country';
    }

    /**
     * Test if unauthenticated users can hit the destroy endpoint
     * @expected: false
     */
    public function test_unauthenticated_users_cannot_hit_the_destroy_endpoint()
    {
        // First we create a test country
        $country = $this->createCountry();

        // Then we assert the country is successfully created on database
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we hit the destroy endpoint
        $this->destroy($country->code)
            // Then we assert status is 401 because we are not authenticated
            ->assertStatus(401);
    }

    /**
     * Test if authenticated users can hit the destroy endpoint and successfully soft-delete it
     * @expected: true
     */
    public function test_authenticated_users_can_hit_destroy_countries_endpoint()
    {
        // First we create a test country
        $country = $this->createCountry();

        // Then we assert the country is successfully created on database
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we setup auth headers from passport
        $this->authenticated()
            // Then we hit the destroy endpoint
            ->destroy($country->code)
            // Then we assert status is 200 because now we are authenticated
            ->assertStatus(200);

        $countryData = $country->toArray();
        $countryData['deleted_at'] = now();

        // Then we assert database has updated record
        $this->assertDatabaseHas('countries', $countryData);
    }

    /**
     * Test if destroyed countries show up on show endpoint
     * @expected: false
     */
    public function test_destroyed_countries_are_not_viewed_on_show_endpoint()
    {
        // First we create a test country
        $country = $this->createCountry();

        // Then we assert the country is successfully created on database
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we hit the show endpoint to check if the country can be viewed by eloquent
        $this->show($country->code)
            // Then we assert status is 200, witch means we found the country
            ->assertStatus(200);

        // Then we setup auth headers from passport
        $this->authenticated()
            // Then we hit the destroy endpoint
            ->destroy($country->code)
            // Then we assert status is 200 because now we are authenticated
            ->assertStatus(200);

        $countryData = $country->toArray();
        $countryData['deleted_at'] = now();

        // Then we assert database has updated record
        $this->assertDatabaseHas('countries', $countryData);

        // Then we check again if the country can be viewed by eloquent
        $this->show($country->code)
            // Finally we assert status is 404, because the record should be deleted
            ->assertStatus(404);
    }

    /**
     * Creates a new destroy country request
     * @param $countryCode
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function destroy($countryCode)
    {
        return $this->makeDeleteRequest(['destroy', $countryCode]);
    }

    /**
     * Creates a new show country request
     * @param $countryCode
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function show($countryCode)
    {
        return $this->makeGetRequest(['show', $countryCode]);
    }
}
