<?php

namespace App\Services\Conversation;

use App\Models\Conversation\Chat;
use App\Models\Conversation\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    protected $chatAction;
    public $conversation;
    public $chat;

    public function __construct(Conversation $conversation, Chat $chat)
    {
        $this->conversation = $conversation;
        $this->chat = $chat;
        $this->chatAction = app(ChatActionHandler::class);
    }

    public function handler()
    {
        if ($this->chat->type == 'meta') {
            return $this->chatAction->notify($this->chat);
        }
    }

    public function getMembers()
    {
        return $this->conversation->users;
    }

    public function getOtherMembers()
    {
        return $this->conversation->users->where('id', '!=', Auth::id());
    }
}
