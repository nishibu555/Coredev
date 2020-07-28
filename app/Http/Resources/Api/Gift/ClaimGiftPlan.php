<?php

namespace App\Http\Resources\Api\Gift;

use App\Http\Resources\Api\User\User;
use App\Http\Resources\Api\Gift\PlannedProduct as PlannedProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaimGiftPlan extends JsonResource
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
            'receiver' => new User($this->receiver)
        ];
    }
}
