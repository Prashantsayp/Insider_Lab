<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cases;
use Faker\Generator as Faker;

$factory->define(Cases::class, function (Faker $faker) {

    return [
        'first_name' => $faker->word,
        'last_name' => $faker->word,
        'mobile' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
