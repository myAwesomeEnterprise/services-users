<?php

namespace App\Listeners\UnBan;

use App\Events\AccountUnBan;
use App\Mail\User\UnBanAccount;
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
     * @param  AccountUnBan $event
     * @return void
     */
    public function handle(AccountUnBan $event)
    {
        $user = $event->user;

        Mail::to($user->email)->send(new UnBanAccount($user));
    }

    public function failed(AccountUnBan $event, $exception)
    {
        //
    }
}
