<?php

namespace App\Http\Resources\Api\User;

use App\Http\Resources\Api\Media;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class User extends JsonResource
{

    public function toArray($request)
    {
        $nonEditables = ['email', 'phone'];
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => optional($this->profile)->gender,
            'dob' => optional($this->profile)->dob,
            'photo' => $this->profilePhoto->src,
            'is_phone_verified' => !is_null($this->phone_verified_at),
            'is_email_verified' => !is_null($this->email_verified_at),
            'non_editables' => $nonEditables,
            "connection" => [
                'relation' => optional($this->getConnection($this->connections))->relation,
                'status' => optional($this->getConnection($this->connections))->status
            ]
        ];
    }

    private function getConnection(Collection $connections)
    {
        return $connections->first();
    }
}
