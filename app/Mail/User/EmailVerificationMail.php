<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $link;
    public $email;

    /**
     * Create a new EMAIL instance.
     *
     * @return void
     */
    public function __construct($name, $email, $link)
    {
        $this->link = $link;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the EMAIL.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email verification')
            ->view('emails.email_verification');
    }
}
