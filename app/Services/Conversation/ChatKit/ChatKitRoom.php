<?php


namespace App\Services\Conversation\ChatKit;


class ChatKitRoom extends ChatKitInit
{
    public function createRoom(
        string $roomId,
        string $pusherCreatorId,
        string $roomName = '',
        array $pusherUserIds = [],
        bool $isPrivate = true,
        array $customData = null
    ) {
        return $this->chatkit->createRoom([
            'id' => $roomId,
            'creator_id' => $pusherCreatorId,
            'name' => $roomName,
            'private' => $isPrivate,
            'user_ids' => $this->formatToString($pusherUserIds),
            'custom_data' => $customData
        ]);
    }

    public function updateRoom(
        string $roomId,
        string $pusherCreatorId,
        string $roomName,
        bool $isPrivate = true,
        array $customData = null
    ) {
        return $this->chatkit->updateRoom([
            'id' => $roomId,
            'creator_id' => $pusherCreatorId,
            'name' => $roomName,
            'private' => $isPrivate,
            'custom_data' => $customData
        ]);
    }

    public function deleteRoom($roomId)
    {
        return $this->chatkit->asyncDeleteRoom(['id' => $roomId]);
    }

    public function getRoomDeleteStatus($roomId)
    {
        return $this->chatkit->getDeleteStatus(['id' => $roomId]);
    }

    public function getRoomDetail($roomId)
    {
        return $this->chatkit->getRoom(['id' => $roomId]);
    }

    private function formatToString(array $ids)
    {
        return array_map(function ($id) {
            return (string) $id;
        }, $ids);
    }
}
