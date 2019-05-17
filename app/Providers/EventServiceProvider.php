<?php

namespace App\Providers;

use App\Events\AccountBaned;
use App\Events\AccountUnBan;
use App\Listeners\Ban\SendEmailNotification as SendBanEmailNotification;
use App\Listeners\UnBan\SendEmailNotification as SendUnBanEmailNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        AccountBaned::class => [
            SendBanEmailNotification::class,
        ],

        AccountUnBan::class => [
            SendUnBanEmailNotification::class,
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
