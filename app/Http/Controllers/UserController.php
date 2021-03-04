<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Jetstream\Http\Livewire\LogoutOtherBrowserSessionsForm;

class UserController extends Controller
{
    use PasswordValidationRules;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'profile_photo' => ['nullable','image','mimes:jpg,jpeg,png','max:1024'],
            'name' => ['required','string','min:3'],
            'telegram' => ['nullable','string'],
            'mobile' => ['nullable','numeric'],
            'country' => ['nullable','string'],
            'address' => ['nullable','string'],
            'city' => ['nullable','string'],
        ]);

        try {
            $user = User::findOrFail($request->user()->id);
            if (isset($request->profile_photo)) {
                $user->updateProfilePhoto($request->profile_photo);
            }
            $user->forceFill([
                'name' => $request->name,
                'telegram' => $request->telegram,
                'mobile' => $request->mobile,
                'country' => $request->country,
                'address' => $request->address,
                'city' => $request->city,
            ])->save();
            return back()->with(['success' => 'Your profile updated successfully!']);
        } catch (\Exception $e)
        {
            return back()->withErrors(['error' => 'Your profile could not be updated']);
        }
    }

    public function updateFromAdmin(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required','string','min:3'],
            'email' => ['required','string','email:dns',Rule::unique('users')->ignore($user->id)],
            'address' => ['nullable','string'],
            'city' => ['nullable','string'],
            'country' => ['nullable','string'],
            'mobile' => ['nullable','numeric'],
            'telegram' => ['nullable','string'],
            'referral' => ['nullable','integer'],
        ]);

        try {
            $user = User::findOrFail($user->id);
            $user->forceFill([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'mobile' => $request->mobile,
                'telegram' => $request->telegram,
                'referral' => $request->referral
            ])->save();

            return back()->with(['success' => 'Profile updated successfully!']);
        } catch (\Exception $e)
        {
            return back()->with(['error' => 'Profile could not be updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function updatePassword(Request $request, UpdatesUserPasswords $updater)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => $this->passwordRules(),
        ]);

        if (! Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json(
                ['errors' => ['current_password' => __('The provided password does not match your current password.')],
                 'message' => __('The given data was invalid!'),
                ], 422);
        }

        try
        {
            $updater->update($request->user(), $request->all());
            return response()->json(['success' => 'Password changed successfully! Please sign in again.']);
        } catch (\Exception $e)
        {
            return response()->json(['message' => 'The password could not be changed']);
        }
    }

    public function killSessions(Request $request, StatefulGuard $guard)
    {
        if(Hash::check($request->password, Auth::user()->password))
        {
            try {
                $guard->logoutOtherDevices($request->password);

                if (config('session.driver') !== 'database') {
                    return;
                }

                DB::table(config('session.table', 'sessions'))
                    ->where('user_id', Auth::user()->getAuthIdentifier())
                    ->where('id', '!=', request()->session()->getId())
                    ->delete();

                return response()->json(['success' => 'All other sessions have been terminated!']);
            } catch (\Exception $e)
            {
                return response()->json(['message' => 'All other sessions could not be terminated']);
            }
        } else {
            return response()->json(['message' => 'You entered your password incorrectly.']);
        }
    }

    public function enable2FA(EnableTwoFactorAuthentication $enable)
    {
        try {
            $enable(Auth::user());
            return response()->json([
                'success' => 'Two factor authentication is successfully enabled!',
                'qrcode' => auth()->user()->twoFactorQrCodeSvg(),
                'recovery' => json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true),
            ]);
        } catch (\Exception $e)
        {
            return response()->json(['message' => 'Two factor authentication could not be enabled']);
        }
    }

    public function disable2FA(DisableTwoFactorAuthentication $disable)
    {
        try {
            $disable(Auth::user());
            return response()->json(['success' => 'Two factor authentication is successfully disabled!']);
        } catch (\Exception $e)
        {
            return response()->json(['message' => 'Two factor authentication could not be disabled']);
        }
    }

    public function readAllNotifications()
    {
        \auth()->user()->unreadNotifications->markAsRead();
        return back();
    }

    public function switchLight()
    {
        $user = Auth::user();
        $user->theme = 'light';
        $user->save();
    }

    public function switchDark()
    {
        $user = Auth::user();
        $user->theme = 'dark';
        $user->save();
    }

    public function assign($user, $role)
    {
        User::findOrFail($user)->assignRole($role);
        return back()->with(['success' => __('Role successfully assigned.')]);
    }

    public function unassign($user, $role)
    {
        User::findOrFail($user)->removeRole($role);
        return back()->with(['success' => __('Role successfully unassigned.')]);
    }

    public function ban($user)
    {

    }

    public function unban($user)
    {

    }
}
