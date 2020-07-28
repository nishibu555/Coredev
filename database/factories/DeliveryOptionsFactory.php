<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Models\DeliveryOption;
use Faker\Generator as Faker;

$factory->define(DeliveryOption::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'sub_title' => $faker->text(100),
        'min_days' => $faker->numberBetween(1, 5),
        'max_days' => $faker->numberBetween(5, 10),
        'price' => $faker->numberBetween(50, 1000),
        'threshold_amount' => null,
        'merchant_id' => null
    ];
});
