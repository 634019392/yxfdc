<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'username' => $faker->userName,
        'truename' => $faker->name(),
        'password' => bcrypt('123123'),
        'email' => $faker->email,
        'phone' => $faker->tollFreePhoneNumber,
        'sex' => ['先生', '女士'][rand(0,1)],
        'last_id' => $faker->ipv4,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
