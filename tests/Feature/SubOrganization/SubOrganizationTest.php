<?php

namespace Tests\Feature\SubOrganization;


use App\SubOrganization;
use Tests\DatabaseActiveTest;

abstract class SubOrganizationTest extends DatabaseActiveTest
{

    /**
     *  Get the api resource for the test
     */
    function apiResource(): string
    {
        return 'sub-organizations';
    }

    public function makeSubOrganization($attributes = [], $times = null)
    {
        return make(SubOrganization::class, $attributes, $times);
    }

    public function createSubOrganization($attributes = [], $times = null)
    {
        return create(SubOrganization::class, $attributes, $times);
    }
}