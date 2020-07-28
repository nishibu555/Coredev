<?php

namespace App\Http\Resources\Api\Post;

use App\Http\Resources\Api\Media;
use Illuminate\Http\Resources\Json\JsonResource;

class Reaction extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'reactable_id' => $this->reactable_id,
            'reactable_type' => $this->reactable_type
        ];
    }
}
