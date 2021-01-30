<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class LogFailedLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $event->subject = 'login';
        $event->description = 'Login Failed';
        activity($event->subject)
            ->causedBy($event->user)
            ->withProperties(['status'=>'failed','interface'=>'web', 'IP' => $this->request->ip()])
            ->log($event->description);
    }
}
