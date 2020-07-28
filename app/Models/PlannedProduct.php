<?php

namespace App\Models;

use App\Models\Gift\GiftPlan;
use Illuminate\Database\Eloquent\Model;

class PlannedProduct extends Model
{
    protected $fillable = [
        'plan_id',
        'sender_id',
        'color_name',
        'color_code',
        'type',
        'provider',
        'url',
        'price',
        'size',
        'product_id',
    ];

    public function giftPlan()
    {
        return $this->belongsTo(GiftPlan::class, 'plan_id');
    }
}
