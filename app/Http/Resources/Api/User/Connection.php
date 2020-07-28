<?php

namespace App\Http\Resources\Api\User;

use App\Http\Resources\Api\Media;
use Illuminate\Http\Resources\Json\JsonResource;

class Connection extends JsonResource
{
    public function toArray($request)
    {
        $photo = null;

        if ($this->connectedUser->profilePhoto) {
            $photo = new Media($this->connectedUser->profilePhoto);
        } else {
            $photo = new Media(new \App\Models\Media(['src' => '/images/dummy/users/profile.png']));
        }

        return [
            'id' => $this->connectedUser->id,
            "first_name" =>  $this->connectedUser->first_name,
            "last_name" => $this->connectedUser->last_name,
            "email" => $this->connectedUser->email,
            "phone" =>  $this->connectedUser->phone,
            "gender" => optional($this->connectedUser->profile)->gender,
            "dob" =>  optional($this->connectedUser->profile)->dob,
            "photo" =>  $photo,
            "is_phone_verified" => !is_null($this->connectedUser->is_phone_verified),
            "is_email_verified" => !is_null($this->connectedUser->is_email_verified),
            "connection" => [
                'relation' => $this->relation,
                'status' => $this->status,
            ]
        ];
    }
}
