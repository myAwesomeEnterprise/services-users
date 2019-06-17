<?php

namespace App\Listeners\UnBan;

use App\Events\AccountUnBan;
use App\Mail\User\UnBanAccount;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 30;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * Create the event listener.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
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

        $this->mailer->to($user->email)
            ->send(new UnBanAccount($user));
    }

    public function failed(AccountUnBan $event, $exception)
    {
        //
    }
}
