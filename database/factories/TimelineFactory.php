<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$relations = \App\Models\Config\Relation::pluck('value')->toArray();
$occassions = \App\Models\Config\Occasion::pluck('value')->toArray();
$actions = ['sent', 'received'];
$factory->define(\App\Models\Timeline::class, function (Faker $faker) use($relations, $occassions, $actions) {
    return [
        'relation' => $faker->randomElement($relations),
        'occasion' => $faker->randomElement($occassions),
        'user_id' => null,
        'action_user_id' => null,
        'gift_plan_id' => null,
        'gift_item' => $faker->text(10),
        'price' => $faker->numberBetween(100, 1000),
        'action' => $faker->randomElement($actions),
        'action_user_name' => $faker->name,
        'currency' => 'GBP',
        'event_date' => now()
    ];
});
