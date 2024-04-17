<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PinCodes;
use Faker\Generator as Faker;

$factory->define(PinCodes::class, function (Faker $faker) {

    return [
        'pin_code' => $faker->word,
        'ff_available' => $faker->word,
        'bank_available' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
