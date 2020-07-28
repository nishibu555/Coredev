<?php

namespace App\Http\Resources\Api\Event;

use App\Http\Resources\Api\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'occasion' => $this->occasion->name,
            'user' => new User($this->user),
            'is_repeat' => $this->is_repeat,
            'visibility' => $this->visibility,
            'date' => $this->date,
            'formatted_date' => $this->date ? $this->date->format(config('app.date_format')) : '',
        ];
    }
}
