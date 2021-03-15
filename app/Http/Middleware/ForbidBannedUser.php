<?php

namespace App\Http\Middleware;

use Closure;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForbidBannedUser
{
    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $this->auth->user();

        if ($user && $user instanceof BannableContract && $user->isBanned()) {
            $request->session()->invalidate();

            return redirect()->route('login')->with(['error' => 'Your account is blocked']);
        }

        return $next($request);
    }
}
