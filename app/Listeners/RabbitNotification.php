<?php

namespace App\Listeners;

use App\Events\Rabbit;

class RabbitNotification
{
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
