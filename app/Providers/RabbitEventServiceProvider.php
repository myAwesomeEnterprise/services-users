<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
    ];
}
