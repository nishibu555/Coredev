<?php

namespace App\Http\Resources\Api\DeliveryOption;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOption extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title ?? null,
            'sub_title' => $this->sub_title ?? null,
            'min_days' => $this->min_days ?? null,
            'max_days' => $this->max_days ?? null,
            'price' => $this->price ?? null,
            'threshold_amount' => $this->threshold_amount ?? null
        ];
    }
}
