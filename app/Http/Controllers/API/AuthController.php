<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ApiResponser;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Fortify\Rules\Password;

class AuthController extends Controller
{
    use ApiResponser;
    use PasswordValidationRules;

    public function register(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ]);

        $request->interface = "Mobile App";

        // If Reference System is available, get referral user:
        $referral_id = null;
        if(Setting::value('mlm_status'))
        {
            $referral_id = isset($input['reference']) ? User::where('refer_hash', $input['reference'])->first()->id : null;
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'refer_hash' => strtoupper(Str::random(10)),
            'referral' => $referral_id,
        ]);

        //Wallet Creation
        (new \App\Http\Controllers\WalletController)->createWallets($user->id);

        return $this->success([
            'token' => $user->createToken('API')->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => [
                'required',
                'string',
                (new Password)->length(8)->requireUppercase()->requireNumeric()->requireSpecialCharacter(),
                ],
        ]);

        $request->interface = "Mobile App";

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        if (! $request->user() || ($request->user() instanceof MustVerifyEmail && ! $request->user()->hasVerifiedEmail())) {
            return $this->error('Your e-mail has not been verified', 401);
        }

        if ($request->user() && $request->user() instanceof BannableContract && $request->user()->isBanned()) {
            return $this->error('This account is blocked',403, ['comment' => $request->user()->bans()->first('comment')]);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API')->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success([
            'message' => 'Tokens Revoked'
        ]);
    }
}
