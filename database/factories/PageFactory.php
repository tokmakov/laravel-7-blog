<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Page;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Page::class, function (Faker $faker) {
    $name = $faker->realText(rand(20, 30));
    $content = '<p>' . $faker->realText(rand(400, 500)) . '</p>' .
        '<p>' . $faker->realText(rand(400, 500)) . '</p>' .
        '<p>' . $faker->realText(rand(400, 500)) . '</p>';
    return [
        'name' => $name,
        'content' => $content,
        'slug' => Str::slug($name) . '-' . rand(100, 999),
    ];
});
