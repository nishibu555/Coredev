<?php

namespace App\Jobs\Chat\ChatKit;

use App\Models\Conversation\Conversation;
use App\Services\Conversation\ChatKit\ChatKitRoom;
use App\Services\Conversation\ChatKit\ChatKitUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChatKitRoomCreate
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var ChatKitRoom
     */
    protected $chatKitRoom;
    public $conversation;
    public $members;

    /**
     * Create a new job instance.
     *
     * @param Conversation $conversation
     * @param array $members
     */
    public function __construct(Conversation $conversation, array $members)
    {
        $this->conversation = $conversation;
        $this->chatKitRoom = app(ChatKitRoom::class);
        $this->members = $members;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->chatKitRoom->createRoom(
                (string) $this->conversation->id,
                auth()->id(),
                $this->decideName(),
                $this->members
            );
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }

    public function decideName()
    {
        if ($this->conversation->is_anonymous) {
            if ($this->conversation->name) {
                return $this->conversation->name;
            }
            return 'Anonymous';
        }
        return '';
    }
}
