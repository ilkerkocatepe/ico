<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponser;

    public function user()
    {
        return $this->success(auth()->user());
    }

    public function wallet()
    {
        return $this->success(auth()->user()->wallet);
    }

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
            return $this->success('', __('Your profile updated successfully'));
        } catch (\Exception $e)
        {
            return $this->error(__('Your profile could not be updated'),400);
        }
    }
}
