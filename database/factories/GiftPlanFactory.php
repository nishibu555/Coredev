<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Gift\GiftPlan;
use Faker\Generator as Faker;

$factory->define(GiftPlan::class, function (Faker $faker) {
    return [
        'sender_id' => null,
        'receiver_id' => null,
        'occasion' => null,
        'relation' => null,
        'giftee_gender' => null,
        'giftee_age_range' => null,
        'budget' => $faker->numberBetween(50, 1000),
        'share_budget' => $faker->boolean,
        'currency' => 'GBP',
        'status' => $faker->randomElement(array_keys(config('enums.gift_plans_statuses'))),
        'is_anonymous' => $faker->boolean,
        'receiver_relation_with_giftee' => $faker->randomElement(['Father', 'Mother', 'Son', 'Daughter']),
        'giftee_name' => $faker->name,
    ];
});
