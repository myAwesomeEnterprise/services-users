<?php

namespace App\Listeners\Ban;

use App\Entities\User;
use App\Mail\User\BanAccount;
use Illuminate\Contracts\Mail\Mailer;

class SendEmailNotification
{
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
     * @param  array  $payload
     * @return void
     */
    public function handle(array $payload)
    {
        $user = User::find($payload["user_id"]);

        $this->mailer->to($user->email)
            ->send(new BanAccount($user));
    }
}
