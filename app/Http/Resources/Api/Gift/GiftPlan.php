<?php

namespace App\Http\Resources\Api\Gift;

use App\Http\Resources\Api\User\User;
use App\Http\Resources\Api\Gift\PlannedProduct as PlannedProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftPlan extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'gift_plan_id' => $this->id,
            'status' => $this->status,
            'relation' => $this->relation,
            'occasion' => $this->occasion,
            'budget' => $this->budget,
            'share_budget' => (bool)$this->share_budget,
            'idea_level' => $this->idea_level,
            'is_anonymous' => $this->is_anonymous,
            'giftee_name' => $this->giftee_name,
            'giftee_gender' => $this->giftee_gender,
            'giftee_age_range' => $this->giftee_age_range,
            'receiver' => new User($this->receiver),
            'planned_product' => PlannedProductResource::collection($this->plannedProducts),
            'choosen_gift' => new Gift($this->gift),
            'created_at' => $this->created_at->toDateTimeString(),
            'viewed_at' => optional($this->viewed_at)->toDateTimeString(),
            'ignored_at' => optional($this->ignored_at)->toDateTimeString(),
            'is_required_delivery_address' => $this->is_required_delivery_address,
        ];
    }
}
