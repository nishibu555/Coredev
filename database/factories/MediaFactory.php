<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Media;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(config('enums.media_types')),
        'src' => $faker->imageUrl(),
        'title' => null,
        'description' => null,
        'extension' => null,
        'mediable_id' => null,
        'mediable_type' => null,
    ];
});
