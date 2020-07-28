<?php


namespace App\Services\Conversation\ChatKit;


class ChatKitMessage extends ChatKitInit
{
    public function sendMessage(string $pusherUserId, string $roomId, string $message)
    {
        return $this->chatkit->sendSimpleMessage([
            'sender_id' => $pusherUserId,
            'room_id' => $roomId,
            'text' => $message,
        ]);
    }

    public function sendMultipartMessage(string $pusherUserId, string $roomId, array $messages)
    {
        return $this->chatkit->sendMultipartMessage([
            'sender_id' => $pusherUserId,
            'room_id' => $roomId,
            'parts' => $messages
        ]);
    }

    public function getRoomMessages(string $roomId)
    {
        return $this->chatkit->fetchMultipartMessages(['room_id' => $roomId]);
    }

    public function deleteMessage(string $roomId, string $messageId)
    {
        return $this->chatkit->deleteMessage(['message_id' => $messageId, 'room_id' => $roomId]);
    }
}
