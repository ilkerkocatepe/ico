<?php

namespace App\Listeners;


use Browser;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->subject = 'login';
        $event->description = 'Login Successful';
        activity($event->subject)
            ->causedBy($event->user)
            ->withProperties([
                'status'=>'success',
                'interface'=>'web',
                'IP' => $this->request->ip(),
                'platform' => \Browser::platformName(),
                'browser' => \Browser::browserFamily(),
                'all' => $this->request->all(),
                ])
            ->log($event->description);
    }
}
