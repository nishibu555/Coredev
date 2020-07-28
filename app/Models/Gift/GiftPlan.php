<?php

namespace App\Models\Gift;

use App\Models\PlannedProduct;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class GiftPlan extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'relation',
        'occasion',
        'budget',
        'share_budget',
        'currency',
        'status',
        'is_anonymous',
        'idea_level',
        'receiver_relation_with_giftee',
        'giftee_name',
        'giftee_age_range',
        'giftee_gender',
        'claiming_token',
        'viewed_at',
        'ignored_at',
        'occasion_date',
        "is_required_delivery_address",
        "delivery_address_id"
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function gift()
    {
        return $this->hasOne(Gift::class, 'plan_id');
    }

    public function getPlannedTimeDiffAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function plannedProducts()
    {
        return $this->hasMany(PlannedProduct::class, 'plan_id');
    }
}
