<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class PaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Events\PaymentReceived
     */
    private $event;

    /**
     * Create a new notification instance.
     *
     * @param \App\Events\PaymentReceived $event
     */
    public function __construct(\App\Events\PaymentReceived $event)
    {
        //
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->telegram ? ['mail',TelegramChannel::class] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Payment Request Received')
                ->line('Your payment request has been received. You will be notified if it is approved or rejected.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toTelegram($notifiable)
    {

        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->telegram)
            // Markdown supported.
            ->content("Payment Request Received!\nYour payment request has been received. You will be notified if it is approved or rejected.");
    }
}
