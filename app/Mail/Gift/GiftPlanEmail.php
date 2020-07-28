<?php

namespace App\Mail\Gift;

use App\Models\Gift\GiftPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GiftPlanEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $giftPlan;
    public $link;
    public $mailSubject;

    /**
     * Create a new message instance.
     *
     * @param GiftPlan $giftPlan
     */
    public function __construct(GiftPlan $giftPlan, $link, $mailSubject)
    {
        $this->giftPlan = $giftPlan;
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
            ->view('emails.chooseGift.gift_plan');
    }
}
