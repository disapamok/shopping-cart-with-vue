<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Category;
use App\Models\Product;
use App\Models\Roles;
use App\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => Category::inRandomOrder()->value('id'),
        'name' => $faker->word(),
        'price' => $faker->randomFloat(2, 100, 1000),
        'description' => $faker->randomHtml(),
        'image' => $faker->imageUrl(640, 480, 'electorics', true),
        'added_by' => User::whereIn('role_id', [Roles::ADMIN, Roles::SALES_MANAGER])->inRandomOrder()->value('id'),
    ];
});
