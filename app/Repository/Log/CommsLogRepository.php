<?php


namespace App\Repository\Log;


use App\Models\CommsLog;
use Repository\Repository;

class CommsLogRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return CommsLog::class;
    }

    public function store($receiverId, $medium, $subject = null, $content, $status)
    {
        return $this->model()::create([
            'user_id' => $receiverId,
            'medium' => $medium,
            'subject' => $subject,
            'content' => $content,
            'status' => $status,
        ]);
    }
}
