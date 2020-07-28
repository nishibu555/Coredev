<?php

namespace App\Http\Resources\Api\Gift;

use App\Services\Feed\FeedApiService;
use Illuminate\Http\Resources\Json\JsonResource;
class PlannedProduct extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'color_name' => $this->color_name,
            'color_code' => $this->color_code,
            'size' => $this->size,
            'product' => $this->getProduct($this->product_id),
        ];
    }

    public function getProduct($productId)
    {
        $product = app(FeedApiService::class)->get('products/'. $productId);
        unset($product->availabilities, $product->options, $product->similar_products, $product->images);

        return $product;
    }
}
