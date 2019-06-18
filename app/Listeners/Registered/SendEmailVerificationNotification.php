<?php

namespace App\Listeners\Registered;

use App\Entities\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  array $payload
     * @return void
     */
    public function handle(array $payload)
    {
        $user = User::find($payload["user_id"]);

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }
    }
}
