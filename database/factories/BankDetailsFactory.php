<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BankDetails;
use Faker\Generator as Faker;

$factory->define(BankDetails::class, function (Faker $faker) {

    return [
        'bank_details' => $faker->text,
        'terms_and_conditions' => $faker->text,
        'user_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
