<?php

namespace App\Listeners\Gift;

use App\Events\Gift\ConfirmedGiftPlan;
use App\Events\Gift\ReceiverGiftChoosen;
use App\Mail\Gift\GiftChoosenEmail;
use App\Mail\Gift\GiftPlanEmail;
use App\Repository\Log\CommsLogRepository;
use Illuminate\Support\Facades\Mail;

class NotifySenderAboutGift
{
    protected $commsLogRepo;

    public function __construct(CommsLogRepository $commsLogRepo)
    {
        $this->commsLogRepo = $commsLogRepo;
    }

    /**
     * @param ConfirmedGiftPlan $event
     * @throws \Throwable
     */
    public function handle(ReceiverGiftChoosen $event)
    {
        $subject = 'Choosen Gift';
        if ($event->sender) {
            $content = view('emails.chooseGift.choosen', ['sender' =>  $event->sender, 'link' => $event->link])->render();

            if (Mail::to($event->sender->email)->send(new GiftChoosenEmail($event->sender, $event->link, $subject))) {
                $this->commsLogRepo->store($event->sender->id, 'email', $subject, $content, 'success');
            } else {
                $this->commsLogRepo->store($event->sender->id, 'email', $subject, $content, 'fail');
            }
        }
    }
}
