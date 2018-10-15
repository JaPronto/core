<?php

namespace Tests\Feature\Country;


use App\Country;

trait CountryTest
{
    public function createCountry()
    {
        return create(Country::class);
    }

    public function makeCountry()
    {
        return make(Country::class);
    }
}