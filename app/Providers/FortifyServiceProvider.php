<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request)
        {
            /*$score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'login');*/

            /*Validator::make($request->only('g-recaptcha-response'), [
                'g-recaptcha-response' => ['required','recaptchav3:login,0.5'],
            ])->validate();*/ // closed for local

            $user = User::where('email', $request->email)->first();
            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

    }
}
