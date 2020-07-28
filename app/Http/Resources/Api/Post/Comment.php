<?php

namespace App\Http\Resources\Api\Post;

use App\Http\Resources\Api\Media;
use App\Http\Resources\Api\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => new User($this->user),
            'post_id' => $this->post_id,
            'message' => $this->message,
            'parent_comment_id' => $this->parent_comment_id,
            'images' => Media::collection($this->images),
            'videos' => Media::collection($this->videos),
            'created_date' => $this->created_at->format(config('app.date_time_format')),
        ];
    }
}
