<?php

namespace App\Http\Resources\Api\Gift;

use App\Http\Resources\Api\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Timeline extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->user_id ? new User($this->user) : [];

        $actionUser = [ 'name' => $this->action_user_name ];
        if ($this->action_user_id) {
            $actionUser = new User($this->actionUser);
        }

        $plan = $this->gift_plan_id ? new GiftPlan($this->plan) : null;
        $status = $plan ? $plan->status : $this->action;
        if($status == 'received') {
            $status = 'accepted';
        }

        return [
            'id' => $this->id,
            'gift_plan_id' => $this->gift_plan_id,
            'gift_item' => $this->gift_item,
            'relation' => $this->relation,
            'occasion' => $this->occasion,
            'status' => $status,
            'price' => $this->price,
            'currency' => $this->currency,
            'event_date' => $this->event_date,
            'sender' => $this->action == 'sent' ? $user : $actionUser,
            'receiver' => $this->action == 'sent' ? $actionUser : $user ,
            'formatted_date' => $this->event_date ? $this->event_date->format(config('app.date_format')) : '',
        ];
    }
}
