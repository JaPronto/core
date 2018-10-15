<?php

namespace Tests\Feature\Country;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Tests\Traits\HasApiResource;

class ReadTest extends CountryTest
{

    /**
     * Test if unauthenticated users can read countries
     * @expected: true
     */
    public function test_unauthenticated_users_can_read_countries()
    {
        // First we create a test country
        $country = $this->createCountry();
        // Then we create a read request without auth headers
        $response = $this->read();

        // Then we assert database has the created record
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we assert status is 200, since anyone can read countries
        $response->assertStatus(200)
            // Then we assert created country code is on response body
            ->assertSeeText($country->code)
            // Then we assert created country name is on response body
            ->assertSeeText($country->name)
            // Then we assert response structure matches pagination structure
            ->assertPaginationResource();
    }

    /**
     * Test if authenticated users can read countries
     * @expected: true
     */
    public function test_authenticated_users_can_read_countries()
    {
        // First we create a test country
        $country = $this->createCountry();
        // Then we create a read request without auth headers
        $response = $this->authenticated()->read();

        // Then we assert database has the created record
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we assert status is 200, since anyone can read countries
        $response->assertStatus(200)
            // Then we assert created country code is on response body
            ->assertSeeText($country->code)
            // Then we assert created country name is on response body
            ->assertSeeText($country->name)
            // Then we assert response structure matches pagination structure
            ->assertPaginationResource();
    }

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'country';
    }

    /**
     * Creates a read countries request
     * @return TestResponse
     */
    public function read()
    {
        return $this->makeGetRequest('index');
    }
}
