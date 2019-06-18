<?php

namespace App\Providers;

use Nuwber\Events\BroadcastEventServiceProvider;

class RabbitEventServiceProvider extends BroadcastEventServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'rabbit.echo' => [
            'App\Listeners\RabbitNotification',
        ],

        'users.registered' => [
            'App\Listeners\Registered\SendEmailVerificationNotification',
        ],

        'users.ban' => [
            'App\Listeners\Ban\SendEmailNotification',
        ],

        'users.un.ban' => [
            'App\Listeners\UnBan\SendEmailNotification',
        ],
    ];
}
