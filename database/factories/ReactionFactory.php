<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
$factory->define(\App\Models\Reaction::class, function (Faker $faker) {
    return [
        'user_id' => null,
        'type' => $faker->randomElement(config('enums.reaction_types')),
        'reactable_id' => null,
        'reactable_type' => null

    ];
});
