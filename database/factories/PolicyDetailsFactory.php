<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PolicyDetails;
use Faker\Generator as Faker;

$factory->define(PolicyDetails::class, function (Faker $faker) {

    return [
        'policy_id' => $faker->randomDigitNotNull,
        'linked_condition_key' => $faker->word,
        'condition' => $faker->word,
        'condition_value' => $faker->randomDigitNotNull,
        'condition_type' => $faker->word,
        'parent_condition_id' => $faker->randomDigitNotNull,
        'parent_condition_value' => $faker->word
    ];
});
