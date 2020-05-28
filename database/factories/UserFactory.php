<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    $ran_phone = '1'.mt_rand(3,9).str_pad(mt_rand(0,999999999), 9, '0', STR_PAD_LEFT);
    return [
        'username' => $faker->userName,
        'truename' => $faker->name(),
        'password' => bcrypt('123123'),
        'email' => $faker->email,
        'phone' => $ran_phone,
        'sex' => ['先生', '女士'][rand(0,1)],
        'last_id' => $faker->ipv4,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
