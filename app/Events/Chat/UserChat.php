<?php

namespace App\Events\Chat;

use App\Models\Conversation\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    /**
     * Create a new event instance.
     *
     * @param Chat $chat
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->chat->receiver_id);
    }

    public function broadcastWith()
    {
        $receiver = $this->chat->receiver;
        return [
            'is_anonymous' => $this->chat->is_anonymous,
            'message' => $this->chat->message,
            'sender' => $this->checkAnonymous(),
            'receiver' => [
                'id' => $receiver->id,
                'name' => $receiver->name,
                'picture' => $receiver->profilePhoto->src
            ],
        ];
    }

    private function checkAnonymous()
    {
        $sender = $this->chat->sender;
        $isAnonymous = $this->chat->is_anonymous;

        return [
            'id' => $sender->id,
            'name' => $isAnonymous ? 'Anonymous' : $sender->name,
            'picture' => $isAnonymous ? '' : $sender->profilePhoto->src,
        ];
    }
}
