<?php

namespace App\Http\Resources\Api\Product;

use App\Http\Resources\Api\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Favorite extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user_id,
            'product_id' => $this->product_id
        ];
    }
}
