<?php

namespace Repository\Event;

use App\Models\Event;
use App\Repository\User\ConnectionRepository;
use Illuminate\Support\Collection;
use Repository\Repository;

class EventRepository extends Repository
{
    protected $connectionRepo;

    public function __construct(ConnectionRepository $connectionRepo)
    {
        $this->connectionRepo = $connectionRepo;
    }

    public function model()
    {
        return Event::class;
    }

    public function getUpcomingEventsByUser($userId, $limit = null): Collection
    {
        $connectionIds = $this->connectionRepo->getConnectionIdsByUser($userId);

        return $this->model()::whereIn('user_id', $connectionIds)
                ->whereDate('date', '>=', today())
                ->where('visibility', '!=', 'private')
                ->limit($limit)
                ->get();
    }

    public function getEventsByUser($userId, $limit = null): Collection
    {
        return $this->model()::where('user_id', $userId)->limit($limit)->get();
    }
}
