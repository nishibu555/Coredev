<?php

namespace App\Mail\Gift;

use App\Models\Gift\GiftPlan;
use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GiftChoosenEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $sender;
    public $mailSubject;

    /**
     * Create a new message instance.
     *
     * @param GiftPlan $giftPlan
     */
    public function __construct(User $sender, $link, $mailSubject)
    {
        $this->sender = $sender;
        $this->link = $link;
        $this->mailSubject = $mailSubject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailSubject)
            ->view('emails.chooseGift.choosen');
    }
}
