<?php

namespace Tests\Feature\Country;


use App\Country;
use Tests\DatabaseActiveTest;

abstract class CountryTest extends DatabaseActiveTest
{
    function apiResource(): string
    {
        return 'countries';
    }

    public function createCountry($attributes = [], $times = null)
    {
        return create(Country::class, $attributes, $times);
    }

    public function makeCountry($attributes = [], $times = null)
    {
        return make(Country::class, $attributes, $times);
    }
}