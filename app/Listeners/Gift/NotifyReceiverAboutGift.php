<?php

namespace App\Listeners\Gift;

use App\Events\Gift\ConfirmedGiftPlan;
use App\Mail\Gift\GiftPlanEmail;
use App\Repository\Log\CommsLogRepository;
use Illuminate\Support\Facades\Mail;

class NotifyReceiverAboutGift
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
    public function handle(ConfirmedGiftPlan $event)
    {
        $subject = 'Choose Gifts';
        if ($event->giftPlan->receiver->is_active) {
            $content = view('emails.chooseGift.body', ['giftPlan' =>  $event->giftPlan, 'link' => $event->link])->render();

            if (Mail::to($event->giftPlan->receiver->email)->send(new GiftPlanEmail($event->giftPlan, $event->link, $subject))) {
                $this->commsLogRepo->store($event->giftPlan->receiver->id, 'email', $subject, $content, 'success');
            } else {
                $this->commsLogRepo->store($event->giftPlan->receiver->id, 'email', $subject, $content, 'fail');
            }
        } else {
            if (\Media365\Transmitter\Facades\Transmitter::send("{$event->giftPlan->receiver->phone}", "{$event->link}")) {
                $this->commsLogRepo->store($event->giftPlan->receiver->id, 'sms', $subject, $event->link, 'success');
            } else {
                $this->commsLogRepo->store($event->giftPlan->receiver->id, 'sms', $subject,  $event->link, 'fail');
            }
        }
    }
}
