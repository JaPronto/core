<?php

namespace Tests\Unit;

use App\Country;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_country()
    {
        $this->authenticated();

        $this->assertFalse(auth()->user()->can('create', Country::class));

        $this->authenticatedAdmin();

        $this->assertTrue(auth()->user()->can('create', Country::class));
    }

    public function test_can_read_countries()
    {
        $this->authenticated();

        $this->assertTrue(auth()->user()->can('view', Country::class));

        $this->authenticatedAdmin();

        $this->assertTrue(auth()->user()->can('view', Country::class));
    }

    public function test_can_show_country()
    {
        $country = create(Country::class);

        $this->authenticated();

        $this->assertTrue(auth()->user()->can('show', $country));

        $this->authenticatedAdmin();

        $this->assertTrue(auth()->user()->can('show', $country));
    }

    public function test_can_update_country()
    {
        $country = create(Country::class);

        $this->authenticated();

        $this->assertFalse(auth()->user()->can('update', $country));

        $this->authenticatedAdmin();

        $this->assertTrue(auth()->user()->can('update', $country));
    }

    public function test_can_delete_country()
    {
        $country = create(Country::class);

        $this->authenticated();

        $this->assertFalse(auth()->user()->can('delete', $country));

        $this->authenticatedAdmin();

        $this->assertTrue(auth()->user()->can('delete', $country));
    }

    public function test_can_force_delete_country()
    {
        $country = create(Country::class);

        $this->authenticated();

        $this->assertFalse(auth()->user()->can('forceDelete', $country));

        $this->authenticatedAdmin();

        $this->assertTrue(auth()->user()->can('forceDelete', $country));
    }


    public function test_can_restore_country()
    {
        $country = create(Country::class);

        $this->authenticated();

        $this->assertFalse(auth()->user()->can('restore', $country));

        $this->authenticatedAdmin();

        $this->assertTrue(auth()->user()->can('restore', $country));
    }
}
