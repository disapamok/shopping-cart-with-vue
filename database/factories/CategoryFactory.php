<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});

$factory->state(Category::class, 'category', function (Faker $faker) {
    return [
        'name' => ucfirst($faker->word)
    ];
});
