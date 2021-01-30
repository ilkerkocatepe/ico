<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StageRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|integer',
            'softcap' => 'nullable|integer',
            'hardcap' => 'nullable|integer|gt:softcap',
            'min_buy' => 'nullable|integer',
            'max_buy' => 'nullable|integer|gt:min_buy',
            'price_type' => 'nullable',
            'fixed_price' => 'nullable|required_if:price_type,fixed',
            'bonus_status' => 'nullable',
            'bonus_minimum' => 'nullable|integer|required_if:bonus_status,checked',
            'bonus_rate' => 'nullable|integer|max:100|required_if:bonus_status,checked',
            'status' => 'required',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date|after:started_at',
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
            'name' => 'Stage Name',
            'description' => 'Stage Description',
            'amount' => 'Token Amount',
            'softcap' => 'Stage Soft Cap',
            'hardcap' => 'Stage Hard Cap',
            'min_buy' => 'Minimum Buy',
            'max_buy' => 'Maximum Buy',
            'price_type' => 'Price Type',
            'fixed_price' => 'Fixed Price',
            'bonus_status' => 'Buying Bonus',
            'bonus_minimum' => 'Bonus Minimum',
            'bonus_rate' => 'Bonus Rate',
            'status' => 'Stage Status',
            'started_at' => 'Start Date',
            'finished_at' => 'End Date',
        ];
    }
}
