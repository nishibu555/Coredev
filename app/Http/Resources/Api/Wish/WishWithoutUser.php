<?php

namespace App\Http\Resources\Api\Wish;

use App\Services\Feed\FeedApiService;
use Illuminate\Http\Resources\Json\JsonResource;

class WishWithoutUser extends JsonResource
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
            'title' => $this->title,
            'status' => $this->status,
            'product' => $this->getProduct($this->product_id)
        ];
    }

    private function getProduct($productId)
    {
        return app(FeedApiService::class)->get('products/'. $productId);
    }
}
