<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

class User extends Authenticatable implements MustVerifyEmail, BannableContract
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use HasRoles;
    use Bannable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'referral',
        'refer_hash',
        'address',
        'city',
        'country',
        'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

/*    public function sendPasswordResetNotification($token)
    {
        $url = 'http://ico.test/reset-password/'.$token;
        $this->notify(new ResetPasswordNotification($url));
    }*/

    public function children()
    {
        return $this->hasMany(self::class, 'referral');
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id','referral');
    }

    public function getLogins()
    {
        return Activity::where('log_name','login')->all();
    }

    public function getLastLogin()
    {
        return Activity::where('log_name','login')->first()->created_at;
    }

    public function getWallets()
    {
        return $this->hasMany('App\Models\Wallet');
    }

    public function getExternalWallets()
    {
        return $this->hasMany('App\Models\ExternalWallet');
    }

    public function enabledExternalWallets()
    {
        return $this->hasMany('App\Models\ExternalWallet')->where('status','1')->get();
    }

    public function getWallet($sym)
    {
        return Wallet::where('user_id', Auth::id())->where('type', $sym)->get();
    }

    public function wallet()
    {
        return $this->hasOne('App\Models\Wallet');
    }

    public function balance()
    {
        return $this->wallet()->balance;
    }

    public function status()
    {
        $status = $this->hasVerifiedEmail() ? "Active" : "Not Verified";

        if($this->isBanned())
        {
            $status = "Banned";
        }

        return $status;
    }

    public function activity()
    {
        return $this->hasMany(Activity::class, 'causer_id');
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function getSessionsProperty(): \Illuminate\Support\Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::table(config('session.table', 'sessions'))
                ->where('user_id', Auth::user()->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            return (object) [
                'agent' => $this->createAgent($session),
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    public function payments()
    {
        return $this->hasMany(CryptoPay::class);
    }

    public function bonus_earnings()
    {
        return $this->hasMany(BonusEarnings::class);
    }

    public function referral_earnings()
    {
        return $this->hasMany(ReferralEarnings::class);
    }

}
