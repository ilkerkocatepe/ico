<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CryptoPayUpdateRequest extends FormRequest
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
            'amount' => 'required|integer',
            'price' => 'required|numeric',
            'txhash' => 'required|string',
            'user_note' => 'nullable|string',
            'admin_note' => 'nullable|string',
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
            'amount' => 'Amount',
            'price' => 'Token Price',
            'txhash' => 'Tx Hash',
            'user_note' => 'User Note',
            'admin_note' => 'Admin Note',
        ];
    }
}
