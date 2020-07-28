<?php

namespace App\Http\Resources\Api\Conversation;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class User extends JsonResource
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
          'name' => $this->first_name . ' ' . $this->last_name,
          'photo' => $this->profilePhoto->src,
          'last_seen_id' => optional($this->pivot)->last_seen_chat_id,
          'created_at' => optional($this->pivot)->created_at
        ];
    }
}
