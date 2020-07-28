<?php

namespace App\Http\Resources\Api\Conversation;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class Conversation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $conversation = [
            'id' => $this->id,
            'name' => $this->decideName(),
            'is_anonymous' => $this->is_anonymous,
            'creator_id' => $this->created_by,
            'created_at' => $this->created_at,
            'anonymous_pic' => Storage::url('images/dummy/users/profile.png')
        ];

        if ($this->created_by == auth()->id() && !$this->is_anonymous) {
            $conversation['users'] = User::collection($this->users);
        } else {
            $conversation['users'] = collect([]);
        }

        return $conversation;
    }

    private function decideName()
    {
        if ($this->is_anonymous) {
            return $this->name ?? 'Anonymous';
        }
        return $this->users->first()->name;
    }
}
