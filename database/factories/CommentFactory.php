<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'post_id' => rand(1, 50),
        'user_id' => rand(1, 10),
        'content' => $faker->realText(rand(200, 500)),
        'created_at' => $faker->dateTimeBetween('-200 days', '-50 days'),
        'updated_at' => $faker->dateTimeBetween('-40 days', '-1 days'),
        'published_by' => rand(1, 3), // супер-админ или просто админ
    ];
});
