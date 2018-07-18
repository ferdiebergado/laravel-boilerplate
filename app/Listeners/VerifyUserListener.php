<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UserCreated;
use App\VerifyUser;
use App\Notifications\VerifyAccountMail;
use App\Notifications\WelcomeMailFromAdmin;

class VerifyUserListener implements ShouldQueue
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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        if (!$event->user->verified) {
            $verifyUser = VerifyUser::create([
                'user_id' => $event->user->id,
                'token' => sha1(time()),
            ]);
            $event->user->notify(new VerifyAccountMail($event->user));
        } else {
            $event->user->update([
                'verified_at' => now()->toDateTimeString()
            ]);
            $event->user->notify(new WelcomeMailFromAdmin($event->user));
        }
    }
}
