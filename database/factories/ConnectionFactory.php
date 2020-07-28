<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\User\Connection;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Connection::class, function (Faker $faker) {
    return [
        'user_id' => null,
        'connected_user_id' => null,
        'relation' => $faker->randomElement(['father', 'mother', 'son', 'daughter']),
        'status' => 'connected'
    ];
});
