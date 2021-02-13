<?php

namespace App\Notifications\User;

use App\Models\ReferralEarnings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralEarning extends Notification
{
    use Queueable;

    public $referral_earning;

    /**
     * Create a new notification instance.
     *
     * @param ReferralEarnings $referral_earning
     */
    public function __construct(ReferralEarnings $referral_earning)
    {
        $this->referral_earning = $referral_earning;
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
            'type' => 'referral-earning',
            'message' => 'You got ' . $this->referral_earning->amount . ' ' . env('TOKEN_SYMBOL') . ' referral earning from your level '.$this->referral_earning->level.'!',
        ];
    }
}
