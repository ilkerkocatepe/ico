<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExternalWalletRequest;
use App\Models\ExternalWallet;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExternalWalletController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->success(auth()->user()->externalWallets, 'Successful');
    }

    public function store(ExternalWalletRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['address'] = preg_replace('/\s+/', '', $validatedData['address']);

        if (isset($validatedData['status']))
        {
            if ($validatedData['status'] == 'checked' && $validatedData['status'] == '1')
            {
                $validatedData['status'] = '1';
            } else {
                $validatedData['status'] = '0';
            }
        } else {
            $validatedData['status'] = '0';
        }

        $validatedData['user_id'] = auth()->id();

        try {
            ExternalWallet::create($validatedData);
            return $this->success('', __('Your external wallet successfully created'));
        } catch (\Exception $e) {
            return $this->error(__('External wallet could not be created'), 400, '');
        }
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'type' => 'required',
            'address' => ['required','string',
                Rule::unique('external_wallets')
                    ->where(static function ($query) {
                        return $query->whereNull('deleted_at');
                    })->ignore($request->id),
            ],
            'status' => 'required',
        ]);

        $validatedData['address'] = preg_replace('/\s+/', '', $validatedData['address']);

        $validatedData['user_id'] = auth()->id();

        try {
            ExternalWallet::find($request->id)->update($validatedData);
            return $this->success(ExternalWallet::find($request->id), __('Your external wallet successfully updated'));
        } catch (\Exception $e) {
            return $this->error(__('External wallet could not be updated'), 400, '');
        }
    }

    public function destroy(Request $request)
    {
        $external_wallet = ExternalWallet::findOrFail($request->id);

        if ($external_wallet->user->id !== auth()->id())
        {
            return $this->error('You are unauthorized for this external wallet',400);
        }

        if ($external_wallet->crypto_pays->count())
        {
            return $this->error(__('You have payment requests belongs to this external wallet'),400);
        }
        try {
            $external_wallet->delete();
            return $this->success('', __('Your external wallet successfully deleted'));
        } catch (\Exception $e) {
            return $this->success('', __('The external wallet could not be deleted'));
        }
    }
}
