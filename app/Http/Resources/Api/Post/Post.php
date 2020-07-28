<?php

namespace App\Http\Resources\Api\Post;

use App\Http\Resources\Api\Event\Event;
use App\Http\Resources\Api\Media;
use App\Http\Resources\Api\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'event' => new Event($this->event),
            'user' => new User($this->user),
            'comments' => Comment::collection($this->comments),
            'images' => Media::collection($this->images),
            'videos' => Media::collection(($this->videos))
        ];
    }
}
