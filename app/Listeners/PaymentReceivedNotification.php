<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class PaymentReceivedNotification implements ShouldQueue
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Create the event listener.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public $queue = 'payment_received';
    public $delay = 60;

    /**
     * Handle the event.
     *
     * @param  PaymentReceived  $event
     * @return void
     */
    public function handle(PaymentReceived $event)
    {
        Notification::send(User::find(1), new \App\Notifications\Admin\PaymentReceived);
        Notification::send(\auth()->user(), new \App\Notifications\User\PaymentReceived);

        $event->subject = 'payment';
        $event->description = 'Payment Received';
        activity($event->subject)
            ->causedBy(\auth()->user())
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
