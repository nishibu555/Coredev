<?php


namespace App\Services\Conversation\ChatKit;


class ChatKitUser extends ChatKitInit
{
    public function authenticateOrCreateUser(string $id, string $name, string  $avatarUrl = null, array $customData = [])
    {
        try {
            $this->getUser($id);
        } catch (\Exception $exception) {
            $this->createUser($id, $name, $avatarUrl, $customData);
        }
        return $this->authenticate($id);
    }

    public function createAuthenticatedUser(string  $id, string $name, string $avatarUrl = null, array $customData = [])
    {
        $this->createUser($id, $name, $avatarUrl, $customData);
        $this->authenticate($id);
    }

    public function createUser(string $id, string $name, string $avatarUrl = null, array $customData = [])
    {
        return $this->chatkit->createUser(
            [
                'id' => $id,
                'name' => $name,
                'avatar_url' => $avatarUrl,
                'custom_data' => $customData
            ]
        );
    }

    public function createUsers(array $users)
    {
        return $this->chatkit->createUsers($users);
    }

    public function updateUser(string $pusherId, string $name, string $avatarUrl = null, array $customData = [])
    {
        return $this->chatkit->updateUser(
            [
                'id' => $pusherId,
                'name' => $name,
                'avatar_url' => $avatarUrl,
                'custom_data' => $customData
            ]
        );
    }

    public function deleteUser(string $pusherUserId)
    {
        return $this->chatkit->asyncDeleteUser(
            [
                'id' => $pusherUserId
            ]
        );
    }

    public function getDeleteStatusOf(string $pusherUserId)
    {
        return $this->chatkit->getDeleteStatus(['id' => $pusherUserId]);
    }

    public function authenticate(string $pusherUserId)
    {
        return $this->chatkit->authenticate(['user_id' => $pusherUserId]);
    }

    public function getUser(string $pusherUserId)
    {
        return $this->chatkit->getUser(['id' => $pusherUserId]);
    }

    public function getUsersByIDs(array $pusherUserIds): array
    {
        return $this->chatkit->getUsersByID($pusherUserIds);
    }


    public function getUserJoinableRooms(string $pusherUserId): array
    {
        return $this->chatkit->getUserJoinableRooms(['id' => $pusherUserId]);
    }

    public function getRoomsOf(string $pusherUserId)
    {
        return $this->chatkit->getRooms(
            [
                'id' => $pusherUserId
            ]
        );
    }

    public function joinUsersToRoom(string $roomId, array $pusherUserIds)
    {
        return $this->chatkit->addUsersToRoom(
            [
                'room_id' => $roomId,
                'user_ids' => $pusherUserIds
            ]
        );
    }

    public function removeUsersFromRoom(string $roomId, array $pusherUserIds)
    {
        return $this->chatkit->removeUsersFromRoom(
            [
                'room_id' => $roomId,
                'user_ids' => $pusherUserIds
            ]
        );
    }
}
