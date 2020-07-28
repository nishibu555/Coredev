<?php

namespace App\Listeners;

use App\Events\NewPhoneAdded;
use App\Mail\Gift\GiftPlanEmail;
use App\Repository\Log\CommsLogRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPhoneVerificationSMS
{
    protected $commsLogRepo;

    public function __construct(CommsLogRepository $commsLogRepo)
    {
        $this->commsLogRepo = $commsLogRepo;
    }

    /**
     * Handle the event.
     *
     * @param  NewPhoneAdded  $event
     * @return void
     */
    public function handle(NewPhoneAdded $event)
    {
        if ($event->user->phone)
        {
            $msg = 'Dear '.$event->user->name.', '. $event->code. ' is your verification OTP. Please verify';

            if (\Media365\Transmitter\Facades\Transmitter::send($event->user->phone, $msg)) {
                $this->commsLogRepo->store($event->user->id, 'sms', '', $msg, 'success');
            } else {
                $this->commsLogRepo->store($event->user->id, 'sms', '', $msg, 'fail');
            }
        }
    }
}
