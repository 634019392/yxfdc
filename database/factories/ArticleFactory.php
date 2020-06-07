<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'desn' => $faker->word,
        'pic' => '/uploads/article/'. rand(1, 7) .'.jpg',
        'body' => $faker->text
    ];
});
