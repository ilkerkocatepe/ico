<?php

namespace App\Mail;

use App\Models\Setting;
use App\Models\User;
use Hamcrest\Core\Set;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $email;
    public $user;
    public $setting;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param string $url
     * @param $user
     * @param string $email
     */
    public function __construct(string $url, $user, string $email)
    {
        $this->url = $url . '?email=' . $email;
        $this->user = $user;
        $this->email = $email;
        $this->setting = Setting::first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.users.resetpassword');
    }
}
