<?php

use Illuminate\Database\Seeder;

class GiftPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = \App\Models\User\User::role('customer')->get();

        foreach (range(1, 10) as $index) {
            $giftPlan = factory(\App\Models\Gift\GiftPlan::class)->create([
                'sender_id' => $customers->pluck('id')->random(),
                'receiver_id' => $customers->pluck('id')->random(),
            ]);

            factory(\App\Models\PlannedProduct::class, 3)->create([
                'sender_id' => $giftPlan->sender_id,
                'plan_id' => $giftPlan->id
            ]);

           $gift = factory(\App\Models\Gift\Gift::class)->create(['plan_id' => $giftPlan->id]);

            factory(\App\Models\Timeline::class)->create(
                [
                    'gift_plan_id' => $giftPlan->id,
                    'user_id' => $giftPlan->sender_id,
                    'action_user_id' => $giftPlan->receiver_id,
                    'price' => $gift->price,
                    'gift_item' => $gift->type,
                    'relation' => $gift->relation,
                    'occasion' => $gift->occasion,
                    'action' => $index < 5 ? 'sent' : 'received',
                ]
            );
        }
    }
}
