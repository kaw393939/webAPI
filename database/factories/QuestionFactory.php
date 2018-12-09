<?php

use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'question' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
    ];
});
