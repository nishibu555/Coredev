<?php

namespace App\Events\Gift;

use App\Models\Gift\GiftPlan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConfirmedGiftPlan
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $giftPlan;
    public $link;

    public function __construct(GiftPlan $giftPlan, $link)
    {
        $this->giftPlan = $giftPlan;
        $this->link = $link;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
