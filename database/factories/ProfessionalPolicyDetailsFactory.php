<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProfessionalPolicyDetails;
use Faker\Generator as Faker;

$factory->define(ProfessionalPolicyDetails::class, function (Faker $faker) {

    return [
        'policy_id' => $faker->randomDigitNotNull,
        'linked_condition_key' => $faker->word,
        'condition' => $faker->word,
        'condition_value' => $faker->word,
        'condition_type' => $faker->word,
        'parent_condition_id' => $faker->randomDigitNotNull,
        'parent_condition_value' => $faker->word,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'calculation_field' => $faker->word,
        'final_value' => $faker->word
    ];
});
