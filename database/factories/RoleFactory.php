<?php

use Faker\Generator as Faker;

$factory->define(App\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'slug' => str_replace(' ', '-', strtolower($faker->words(2, true)))
    ];
});
