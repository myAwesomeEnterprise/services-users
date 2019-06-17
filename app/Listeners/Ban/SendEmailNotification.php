<?php

namespace App\Listeners\Ban;

use App\Events\AccountBaned;
use App\Mail\User\BanAccount;
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
     * @param  AccountBaned  $event
     * @return void
     */
    public function handle(AccountBaned $event)
    {
        $user = $event->user;

        $this->mailer->to($user->email)
            ->send(new BanAccount($user));
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
