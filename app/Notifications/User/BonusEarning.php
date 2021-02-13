<?php

namespace App\Notifications\User;

use App\Models\BonusEarnings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BonusEarning extends Notification implements ShouldQueue
{
    use Queueable;

    public $bonus;

    /**
     * Create a new notification instance.
     *
     * @param BonusEarnings $bonus
     */
    public function __construct(BonusEarnings $bonus)
    {
        $this->bonus = $bonus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //
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
            'type' => 'bonus-earning',
            'message' => 'You have earned ' . $this->bonus->bonus_amount . ' ' . env('TOKEN_SYMBOL') . ' bonus!',
        ];
    }
}
