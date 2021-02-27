<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Tag::class, function (Faker $faker) {
    $name = $faker->realText(rand(20, 25));
    return [
        'name' => $name,
        'slug' => Str::slug($name) . '-' . rand(100, 999),
    ];
});
