<?php

use Faker\Generator as Faker;

$factory->define(App\Language::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Portuguese', 'English', 'Mandarin', 'Japanese', 'Spanish']),
        'code' => $faker->locale
    ];
});
