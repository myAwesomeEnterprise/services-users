<?php

namespace App\Listeners\Ban;

use App\Events\AccountBaned;
use App\Mail\User\BanAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification implements ShouldQueue
{
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 30;

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
     * @param  AccountBaned  $event
     * @return void
     */
    public function handle(AccountBaned $event)
    {
        $user = $event->user;

        Mail::to($user->email)->send(new BanAccount($user));
    }

    /**
     * Handle a job failure
     *
     * @param AccountBaned $event
     * @param $exception
     * @return void
     */
    public function failed(AccountBaned $event, $exception)
    {
        //
    }
}
