<?php

namespace App\Http\Resources\Api\Wish;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWithWishList extends JsonResource
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
            'name' => $this->name,
            'photo' => $this->profilePhoto->src,
            'email' => $this->email,
            'wishList' => WishWithoutUser::collection($this->wishes)
        ];
    }
}
