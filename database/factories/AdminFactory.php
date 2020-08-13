<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        //`name`, `username`, `phone`, `email`, `password`, `logo`, `type`, `status`
        'name' => $faker->name,
        'username' => $faker->userName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'password' => bcrypt('123456'),
        'type' => 'super_admin',
    ];
});
