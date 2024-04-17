<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Documents;
use Faker\Generator as Faker;

$factory->define(Documents::class, function (Faker $faker) {

    return [
        'document_url' => $faker->text,
        'document_type' => $faker->word,
        'agent_id' => $faker->randomDigitNotNull,
        'case_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
