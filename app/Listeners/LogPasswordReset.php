<?php

namespace App\Listeners;

use Browser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class LogPasswordReset
{
    /**
     * Create the event listener.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        $event->subject = 'password-reset';
        $event->description = 'Password Reset Successful';
        activity($event->subject)
            ->causedBy($event->user)
            ->withProperties([
                'status'=>'success',
                'interface'=>'web',
                'IP' => $this->request->ip(),
                'platform' => \Browser::platformName(),
                'browser' => \Browser::browserFamily(),
            ])
            ->log($event->description);
    }
}
