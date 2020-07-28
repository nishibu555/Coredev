<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Gift\Gift;
use Faker\Generator as Faker;

$factory->define(Gift::class, function (Faker $faker) {
    return [
        'sender_budget' => $senderBudget = $faker->numberBetween(50, 1000),
        'receiver_budget' => $faker->numberBetween(1, 20),
        'type' => 'Watch',
        'product_provider' => $faker->randomElement(['eBay', 'Amazon']),
        'plan_id' => null,
        'product_id' => null,
        'color' => $faker->randomElement(['Black', 'Blue', 'White', 'Red', 'Grey']),
        'product_url' => $faker->url,
        'price' => $price = $faker->numberBetween($senderBudget - 10, $senderBudget + 10),
        'sender_payment_contribution' => $senderContrib = $faker->numberBetween($price - 10, $price),
        'receiver_payment_contribution' => $price - $senderContrib
    ];
});
