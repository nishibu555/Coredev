<?php

namespace App\Http\Resources;

use App\Http\Resources\Api\User\User;
use App\Services\Feed\FeedApiService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class Wish extends JsonResource
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
            'id' => $this->id,
            'user' => new User($this->user),
            'product_id' => $this->product_id,
            'product' => app(FeedApiService::class)->get('products/'. $this->product_id),
            'title' => $this->title,
            'status' => $this->status
        ];
    }
}
