<?php

namespace Tests\Unit;

use App\SubOrganization;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubOrganiationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_sub_organization()
    {
        $this->authenticated()
            ->assertFalse(auth()->user()->can('create', SubOrganization::class));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('create', SubOrganization::class));
    }

    public function test_can_read_sub_organization()
    {
        $this->authenticated()
            ->assertTrue(auth()->user()->can('view', SubOrganization::class));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('view', SubOrganization::class));
    }

    public function test_can_show_sub_organization()
    {
        $sub_organization = create(SubOrganization::class);

        $this->authenticated()
            ->assertTrue(auth()->user()->can('show', $sub_organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('show', $sub_organization));
    }

    public function test_can_update_sub_organization()
    {
        $sub_organization = create(SubOrganization::class);

        $this->authenticated()
            ->assertFalse(auth()->user()->can('update', $sub_organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('update', $sub_organization));
    }

    public function test_can_delete_sub_organization()
    {
        $sub_organization = create(SubOrganization::class);

        $this->authenticated()
            ->assertFalse(auth()->user()->can('delete', $sub_organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('delete', $sub_organization));
    }

    public function test_can_force_delete_sub_organization()
    {
        $sub_organization = create(SubOrganization::class);

        $this->authenticated()
            ->assertFalse(auth()->user()->can('forceDelete', $sub_organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('forceDelete', $sub_organization));
    }

    public function test_can_restore_sub_organization()
    {
        $sub_organization = create(SubOrganization::class);

        $this->authenticated()
            ->assertFalse(auth()->user()->can('restore', $sub_organization));

        $this->authenticatedAdmin()
            ->assertTrue(auth()->user()->can('restore', $sub_organization));
    }
}
