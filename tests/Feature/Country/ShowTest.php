<?php

namespace Tests\Feature\Country;

use App\Country;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\HasApiResource;

class ShowTest extends CountryTest
{

    /**
     * Test if authenticated users can view country
     * @expected: true
     */
    public function test_authenticated_users_can_show_country()
    {
        // First we create a test country
        $country = $this->createCountry();
        // Then we create a show request
        $response = $this->authenticated()->show($country->code);

        // Then we assert database has successfully saved country
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we assert status is 200, since anyone can view countries
        $response->assertStatus(200)
            // Then we assert created country name is present on response body
            ->assertSeeText($country->name)
            // Then we assert created country code present on response body
            ->assertSeeText($country->code)
            // Then we assert json structure matches expected
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'code',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Test if unauthenticated users can view country
     * @expected: true
     */
    public function test_unauthenticated_users_can_show_country()
    {
        // First we create a test country
        $country = $this->createCountry();
        // Then we create a show request
        $response = $this->show($country->code);

        // Then we assert database has successfully saved country
        $this->assertDatabaseHas('countries', $country->toArray());

        // Then we assert status is 200, since anyone can view countries
        $response->assertStatus(200)
            // Then we assert created country name is present on response body
            ->assertSeeText($country->name)
            // Then we assert created country code present on response body
            ->assertSeeText($country->code)
            // Then we assert json structure matches expected
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'code',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Creates a show request
     * @param $countryCode
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function show($countryCode)
    {
        return $this->makeGetRequest(['show', $countryCode]);
    }
}
