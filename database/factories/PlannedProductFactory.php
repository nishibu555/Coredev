<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PlannedProduct;
use Faker\Generator as Faker;

$colors = [
    'Black' => '#000000',
    'Blue' =>  '#0000FF',
    'White' => '#FFFFFF',
    'Red' => '#FF0000',
    'Grey' => '#DCDCDC'
];
$factory->define(PlannedProduct::class, function (Faker $faker) use ($colors) {
    $color = array_rand($colors);
    return [
        'plan_id' => null,
        'sender_id' => null,
        'price' => $faker->numberBetween(50, 100),
        'type' => 'Watch',
        'color_name' => $color,
        'color_code' => $colors[$color],
        'provider' => $faker->randomElement(['eBay', 'Amazon']),
        'url' => $faker->url,
    ];
});
