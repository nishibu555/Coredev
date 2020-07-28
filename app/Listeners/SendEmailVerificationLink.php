<?php

namespace App\Listeners;

use App\Events\NewEmailAdded;
use App\Events\UserRegistered;
use App\Mail\Gift\GiftPlanEmail;
use App\Mail\User\EmailVerificationMail;
use App\Repository\Log\CommsLogRepository;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationLink
{
    protected $commsLogRepo;

    public function __construct(CommsLogRepository $commsLogRepo)
    {
        $this->commsLogRepo = $commsLogRepo;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewEmailAdded $event)
    {

        if ($this->isEmail($event->user->email)) {
            $this->sendMail($event);
        }
    }

    private function sendMail($event)
    {
        $subject = 'Email verification';
        $content = view('emails.email_verification', ['name' =>  $event->user->name, 'email' => $event->user->email, 'link' => $event->link])->render();

        if (Mail::to($event->user->email)->send(new EmailVerificationMail($event->user->name, $event->user->email, $event->link))) {
            $this->commsLogRepo->store($event->user->id, 'email', $subject, $content, 'success');

        } else {
            $this->commsLogRepo->store($event->user->id, 'email', $subject, $content, 'fail');
        }
    }

    private function isEmail($email)
    {
       return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
