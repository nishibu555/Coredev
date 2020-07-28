<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class VerificationCode extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'subject' => $this->subject,
            'token' => $this->token,
            //TODO Code is being sent for test purpose; need to remove
            'code' => $this->code,
            'created_at' => $this->created_at->toDateTimeString(),
            'expires_at' => $this->expires_at->toDateTimeString(),
        ];
    }
}
