<?php

namespace App\Http\Resources\Api\Gift;

use App\Http\Resources\Api\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Gift extends JsonResource
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
            'gift_plan_id' => $this->plan_id,
            'sender_budget' => $this->sender_budget,
            'price' => $this->price,
            'share_budget' => $this->share_budget,
            'product_id' => $this->product_id,
            'color' => $this->color,
            'size' => $this->size
        ];
    }
}
