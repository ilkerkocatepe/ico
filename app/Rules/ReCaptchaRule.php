<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class ReCaptchaRule implements Rule
{
    private $error_msg = '';
    private $value = '';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $value = $token;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (empty($value)) {
            $this->error_msg = ':attribute field is required.';
            return false;
        }
        $setting = \App\Models\Setting::first();
        $recaptcha = new ReCaptcha($setting->getSetting('GOOGLE_CAPTCHA_PRIVATE_KEY'));
        $resp      =   $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                                ->setScoreThreshold(0.5)
                                ->verify($value, $_SERVER['REMOTE_ADDR']);

        if (!$resp->isSuccess()) {
            $this->error_msg = 'ReCaptcha field is required.';
            return false;
        }

        if ($resp->getScore() < 0.5) {
            $this->error_msg = 'Failed to validate captcha.';
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        dd($this->error_msg);
    }
}
