<?php

namespace App\Listeners;

use App\Events\Rabbit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RabbitNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  array  $payload
     * @return void
     */
    public function handle(array $payload)
    {
        info('users:--> rabbit notification');
    }
}
