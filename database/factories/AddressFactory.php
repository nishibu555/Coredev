<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'postcode' => $faker->bothify('??# #??'),
        'house_name' => $faker->numberBetween(1, 100),
        'road_no' => $faker->numberBetween(1, 100),
        'road_name' => $faker->streetName,
        'flat' => $faker->bothify('#?'),
        'town' => 'London',
        'line1' => null,
        'months_at_address' => null,
        'county' => 'Essex',
        'type' => 'current',
        'addressable_type' => null,
        'addressable_id' => null,
    ];
});
