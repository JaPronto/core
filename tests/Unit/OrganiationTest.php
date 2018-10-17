<?php

namespace Tests\Unit;

use App\Organization;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganiationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_organization()
    {
        $this->authenticated()
            ->assertFalse(auth()->user()->can('create', Organization::class));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('create', Organization::class));
    }

    public function test_can_read_organization()
    {
        $this->authenticated()
            ->assertTrue(auth()->user()->can('view', Organization::class));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('view', Organization::class));
    }

    public function test_can_show_organization()
    {
        $organization = create(Organization::class);

        $this->authenticated()
            ->assertTrue(auth()->user()->can('show', $organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('show', $organization));
    }

    public function test_can_update_organization()
    {
        $organization = create(Organization::class);

        $this->authenticated()
            ->assertFalse(auth()->user()->can('update', $organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('update', $organization));
    }

    public function test_can_delete_organization()
    {
        $organization = create(Organization::class);

        $this->authenticated()
            ->assertFalse(auth()->user()->can('delete', $organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('delete', $organization));
    }

    public function test_can_force_delete_organization()
    {
        $organization = create(Organization::class);

        $this->authenticated()
            ->assertFalse(auth()->user()->can('forceDelete', $organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('forceDelete', $organization));
    }

    public function test_can_restore_organization()
    {
        $organization = create(Organization::class);

        $this->authenticated()
            ->assertFalse(auth()->user()->can('restore', $organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('restore', $organization));
    }
}
