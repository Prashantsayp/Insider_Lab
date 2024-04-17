<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Agents;
use Faker\Generator as Faker;

$factory->define(Agents::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'email' => $faker->word,
        'pan_card' => $faker->word,
        'aadhar_card' => $faker->word,
        'mobile_verified_at' => $faker->date('Y-m-d H:i:s'),
        'mobile' => $faker->word,
        'location' => $faker->word,
        'email_verified_at' => $faker->date('Y-m-d H:i:s'),
        'password' => $faker->word,
        'remember_token' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'disabled' => $faker->word,
        'user_type' => $faker->word
    ];
});
