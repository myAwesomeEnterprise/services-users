<?php

namespace App\Mail\User;

use App\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class BanAccount extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance
     *
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('service.user.ban.notification.from'))
            ->markdown('emails.user.BanAccount');
    }
}
