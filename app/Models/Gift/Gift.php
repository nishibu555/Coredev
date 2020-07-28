<?php

namespace App\Models\Gift;

use App\Models\Gift\GiftPlan;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected  $fillable = [
        'plan_id',
        'sender_budget',
        'receiver_budget',
        'type',
        'color',
        'size',
        'product_provider',
        'product_url',
        'price',
        'sender_payment_contribution',
        'receiver_payment_contribution',
        'hasBought'
    ];

    public function plan()
    {
        return $this->belongsTo(GiftPlan::class, 'plan_id');
    }
}
