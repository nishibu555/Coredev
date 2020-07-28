<?php

namespace App\Repository\User;

use App\Models\User\Connection;
use Illuminate\Support\Collection;
use Repository\Repository;

class ConnectionRepository extends Repository
{
    public function model()
    {
        return Connection::class;
    }

    public function getPaginatedByUser($userId, $perPage = 15)
    {
        return $this->model()::where('user_id', $userId)->connected()->paginate($perPage);
    }

    public function getConnectionIdsByUser($userId)
    {
        return $this->model()::connected()
            ->where('user_id', $userId)
            ->pluck('connected_user_id')->toArray();
    }

    public function getPeopleMayKnow($userId)
    {
        return $this->model()::connected()
            ->where('user_id', $userId)
            ->pluck('connected_user_id')->toArray();
    }

    public function addConnection($userId, $connectionUserId, $status = 'requested')
    {
        return $this->create([
            'user_id' => $userId,
            'connected_user_id' => $connectionUserId,
            'status' => $status
        ]);
    }

    public function isRequested($userId, $connectionUserId)
    {
        return $this->model()::where('user_id', $connectionUserId)
            ->where('connected_user_id', $userId)
            ->where('status', 'requested')
            ->first();
    }

    public function updateStatus($connectionId, $status)
    {
        return $this->model()::where('id', $connectionId)
                ->update(['status' => $status]);
    }

    public function getByUserId($userId)
    {
        return $this->model()::where('connected_user_id', $userId)
                    ->where('status', 'requested')
                    ->get();
    }
}
