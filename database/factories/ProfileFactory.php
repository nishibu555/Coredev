<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => null,
        'gender' => $faker->randomElement(config('enums.genders')),
        'dob' => $faker->date('Y-m-d', '-18 years'),
    ];
});
