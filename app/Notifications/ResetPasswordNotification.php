<?php

namespace App\Notifications;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword as ResetPasswordMailable;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    public $url;

    /**
     * Create a new notification instance.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return ResetPassword
     */
    public function toMail($notifiable)
    {
        $url = $this->url;
        $email = $notifiable->email;
        $user = User::where('email', $email)->first();
        return (new ResetPasswordMailable($url,$user,$email))
            ->to($notifiable->email);

/*        return (new MailMessage)
                    ->subject('Reset Your Password')
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password', $this->url)
                    ->line('This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.');*/
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
            'process' => 'ResetPassword'
        ];
    }
}
