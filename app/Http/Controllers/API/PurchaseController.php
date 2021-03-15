<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BankGateway;
use App\Models\CryptoGateway;
use App\Models\Sell;
use App\Models\Stage;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    use ApiResponser;

    public function list()
    {
        return $this->success(auth()->user()->payments()->orderBy('created_at','desc')->get(),'Successful');
    }

    public function stages()
    {
        return Stage::where('status','running')->get();
    }

    public function cryptogateways()
    {
        return CryptoGateway::where('status','1')->get();
    }

    public function bankgateways()
    {
        return BankGateway::where('status','1')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => ['required', 'integer'],
            'external_wallet' => ['required', 'integer'],
            'gateway' => ['required', 'integer'],
            'txhash' => ['required', 'string'],
            'user_note' => ['nullable', 'string'],
        ]);

        $result = app(\App\Http\Controllers\PurchaseController::class)->purchase($validatedData);

        if ($result)
        {
            return $this->success($result, __('Payment request created successfully'));
        } else {
            return $this->error(__('Payment request could not be created'),400);
        }

    }

    public function cancel(Request $request)
    {
        $validatedData = $request->validate([
            'sell_id' => ['required', 'integer'],
        ]);
        if(auth()->id() != Sell::findOrFail($validatedData['sell_id'])->user_id)
        {
            return $this->error(__('Purchase request could not find'),401);
        }

        try {
            $purchase = Sell::findOrFail($validatedData['sell_id']);
            $purchase->status = 'canceled';
            $purchase->save();
            return $this->success('', __('Payment request canceled successfully'));
        } catch (\Exception $e)
        {
            return $this->error(__('Payment request could not be canceled'),400);
        }
    }
}
