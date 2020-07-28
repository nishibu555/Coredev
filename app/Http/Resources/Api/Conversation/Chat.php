<?php

namespace App\Http\Resources\Api\Conversation;

use App\Http\Resources\Api\User\SimpleUser;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class Chat extends JsonResource
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
            'is_you' => $this->user_id == auth()->id(),
            'user' => new SimpleUser($this->sender),
            'conversation_id' => $this->conversation_id,
            'message' => $this->formatMessage(json_decode($this->message)),
            'type' => $this->message_type,
            'created_at' => $this->created_at
        ];
    }

    private function formatMessage($message)
    {
        return collect([
            'text' => $message->text,
            'images' => $this->formatImages($message->images)
        ]);
    }

    private function formatImages(array $images)
    {
        return collect($images)->map(function($image) {
            return Storage::url($image);
        });
    }
}
