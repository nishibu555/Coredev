<?php

namespace App\Jobs\Chat\ChatKit;

use App\Models\User\User;
use App\Services\Conversation\ChatKit\ChatKitUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserCreateOrAuthJob
//    implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var ChatKitUser
     */
    protected $chatKitUser;
    public $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->chatKitUser = app(ChatKitUser::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->chatKitUser->authenticateOrCreateUser(
                (string) $this->user->id,
                $this->user->name,
                optional($this->user->profilePhoto)->src
            );
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
