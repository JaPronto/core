<?php

use Faker\Generator as Faker;

$factory->define(App\SubOrganization::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'founded_at' => $faker->dateTimeBetween()->format('Y-m-d H:i:s'),
        'country_id' => function () {
            return factory(\App\Country::class)->create()->id;
        },
        'organization_id' => function () {
            return factory(\App\Organization::class)->create()->id;
        },
        'description' => $faker->text(200)
    ];
});
