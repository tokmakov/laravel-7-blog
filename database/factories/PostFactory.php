<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    $name = $faker->realText(rand(30, 40));
    $content = '<p>' . $faker->realText(rand(400, 500)) . '</p>' .
        '<p>' . $faker->realText(rand(400, 500)) . '</p>' .
        '<p>' . $faker->realText(rand(400, 500)) . '</p>';
    return [
        'user_id' => rand(1, 10),
        'category_id' => rand(1, 12),
        'name' => $name,
        'excerpt' => $faker->realText(rand(250, 300)),
        'content' => $content,
        'slug' => Str::slug($name) . '-' . rand(100, 999),
        'created_at' => $faker->dateTimeBetween('-200 days', '-50 days'),
        'updated_at' => $faker->dateTimeBetween('-40 days', '-1 days'),
        'published_by' => rand(1, 10),
    ];
});
