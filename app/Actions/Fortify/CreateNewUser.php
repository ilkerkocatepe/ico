<?php

namespace App\Actions\Fortify;

use App\Http\Controllers\WalletController;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            /*'g-recaptcha-response' => ['required','recaptchav3:register,0.5'],*/ // closed for local
            'privacy-policy' => ['required'],
        ])->validate();

        // If Reference System is available, get referral user:
        $referral_id = null;
        if(Setting::value('mlm_status'))
        {
            $referral_id = isset($input['reference']) ? User::where('refer_hash', $input['reference'])->first()->id : null;
        }

        $control = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'refer_hash' => strtoupper(Str::random(10)),
            'referral' => $referral_id,
        ]);

        //Wallet Creation
        (new \App\Http\Controllers\WalletController)->createWallets($control->id);

        return $control;
    }
}
