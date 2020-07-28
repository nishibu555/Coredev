<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'country_code' => null,
        'number' => $faker->numerify('07#########'),
        'type' => 'primary',
        'contactable_id' => null,
        'contactable_type' => null,
        'verified_at' => now(),
    ];
});
