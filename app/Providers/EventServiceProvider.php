<?php

namespace App\Providers;

use App\Events\Gift\ConfirmedGiftPlan;
use App\Events\Gift\ReceiverGiftChoosen;
use App\Events\NewEmailAdded;
use App\Events\NewPhoneAdded;
use App\Events\UserRegistered;
use App\Listeners\Gift\NotifyReceiverAboutGift;
use App\Listeners\Gift\NotifySenderAboutGift;
use App\Listeners\SendEmailVerificationLink;
use App\Listeners\SendPhoneVerificationSMS;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class,],
        ConfirmedGiftPlan::class => [NotifyReceiverAboutGift::class,],
        UserRegistered::class => [
            //SendEmailVerificationLink::class
        ],
        NewPhoneAdded::class => [
            SendPhoneVerificationSMS::class,
        ],
        NewEmailAdded::class => [
            SendEmailVerificationLink::class,
        ],
        ReceiverGiftChoosen::class => [
            NotifySenderAboutGift::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
