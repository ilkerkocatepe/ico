<?php

namespace App\Http\Controllers;

use App\Models\BankPay;
use App\Models\Sell;
use App\Models\Setting;
use App\Models\Stage;
use App\Models\User;
use App\Notifications\User\PaymentConfirmed;
use Illuminate\Http\Request;

class BankPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $bank_pays = BankPay::all();
        return view('admin.bank-pays.index', compact('bank_pays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bank-pays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "stage" => "required|integer",
            "gateway" => "required|integer",
            "user" => "required|integer",
            "deposit_amount" => "required|numeric",
            "rate" => "required|numeric",
            "deposit_value" => "required|numeric",
            "user_note" => "nullable|string",
            "admin_note" => "nullable|string",
        ]);
        $request->token_amount = ($request->deposit_amount * $request->rate) / (Stage::findOrFail($request->stage)->fixed_price);
        return view('admin.bank-pays.preview', compact('request'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            "stage_id" => "required|integer",
            "gateway_id" => "required|integer",
            "user_id" => "required|integer",
            "deposit_amount" => "required|numeric",
            "rate" => "required|numeric",
            "deposit_value" => "required|numeric",
            "user_note" => "nullable|string",
            "admin_note" => "nullable|string",
        ]);
        $token_amount = ($request->deposit_amount * $request->rate) / (Stage::findOrFail($request->stage_id)->fixed_price);
        try {
            $payment = BankPay::create([
                "bank_gateway_id" => $request->gateway_id,
                "deposit_amount" => $request->deposit_amount,
                "rate" => $request->rate,
                "value" => $request->deposit_value,
            ]);
            $price = Stage::findOrFail($request->stage_id)->fixed_price;
            $sell = Sell::create([
                'user_id' => $request->user_id,
                'stage_id' => $request->stage_id,
                'method_id' => '2',
                'sellable_id' => $payment->getKey(),
                'sellable_type' => $payment->getMorphClass(),
                'amount' => $token_amount,
                'price' => $price,
                'total' => $price * $token_amount,
                'user_note' => $request->user_note,
                'admin_note' => $request->admin_note,
                'status' => 'confirmed',
            ]);
            app('App\Http\Controllers\SellController')->addBalance($sell->user_id,$sell->amount);
            $msg = __(" Balance added to wallet.");

            $stage = Stage::find($sell->stage_id);
            //  ADD BONUS IF ACTIVE
            if($stage->bonus_status)
            {
                if($stage->bonus_minimum <= $sell->amount)
                {
                    app(BonusEarningsController::class)->addBonus($sell->id);
                    $msg .= __(" Bonus sent.");
                }
            }
            //  ADD REFERRAL EARNINGS IF ACTIVE
            if(Setting::value('mlm_status'))
            {
                if ($sell->user->parent){
                    app(ReferralEarningsController::class)->addReferralEarning($sell->id);
                    $msg .= __(" Referral earnings sent.");
                }
            }
            //  SEND NOTIFICATION TO USER
            dispatch(function () use($sell) {
                User::find($sell->user_id)->notify(new PaymentConfirmed($sell->admin_note));

                activity('bank-payment-add')
                    ->causedBy(\auth()->user())
                    ->withProperties([
                        'status'=>'success',
                        'interface'=>'web',
                        'IP' => request()->ip(),
                        'platform' => \Browser::platformName(),
                        'browser' => \Browser::browserFamily(),
                    ])
                    ->log('Bank Payment Added');
            })->afterResponse();

            return back()->with('success', __('Bank payment successfully added!') . $msg);
        } catch (\Exception $e)
        {
            return back()->with(['error'=>'Bank payment couldn\'t add']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankPay  $bankPay
     * @return \Illuminate\Http\Response
     */
    public function show(BankPay $bankPay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankPay  $bankPay
     * @return \Illuminate\Http\Response
     */
    public function edit(BankPay $bankPay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankPay  $bankPay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankPay $bankPay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankPay  $bankPay
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankPay $bankPay)
    {
        //
    }
}
