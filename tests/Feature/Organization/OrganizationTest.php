<?php

namespace Tests\Feature\Organization;


use App\Organization;
use Tests\DatabaseActiveTest;

abstract class OrganizationTest extends DatabaseActiveTest
{

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'organizations';
    }

    public function createOrganization($attributes = [], $times = null)
    {
        return create(Organization::class, $attributes, $times);
    }

    public function makeOrganization($attributes = [], $times = null)
    {
        return make(Organization::class, $attributes, $times);
    }
}