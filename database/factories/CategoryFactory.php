<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->realText(rand(20, 30));
    return [
        'name' => $name,
        'content' => $faker->realText(rand(200, 500)),
        'slug' => Str::slug($name) . '-' . rand(100, 999),
    ];
});
