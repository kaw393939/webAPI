<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'bio' => $faker->sentence($nbWords = 5, $variableNbWords = true),
    ];
});
