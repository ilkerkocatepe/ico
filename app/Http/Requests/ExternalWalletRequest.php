<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExternalWalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'type' => 'required',
            'address' => ['required','string',
                Rule::unique('external_wallets')
                    ->where(static function ($query) {
                        return $query->whereNull('deleted_at');
                    })->ignore($this->route('external_wallet')),
                ],
            'status' => 'nullable',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Wallet Name',
            'description' => 'Wallet Description',
            'type' => 'Wallet Type',
            'address' => 'Wallet Address',
            'status' => 'Wallet Status',
        ];
    }
}
