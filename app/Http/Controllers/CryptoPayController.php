<?php

namespace App\Http\Controllers;

use App\Http\Requests\CryptoPayUpdateRequest;
use App\Models\BonusEarnings;
use App\Models\CryptoGateway;
use App\Models\CryptoPay;
use App\Models\ReferralEarnings;
use App\Models\Sell;
use App\Models\Setting;
use App\Models\Stage;
use App\Models\User;
use App\Notifications\User\PaymentConfirmed;
use App\Notifications\User\PaymentRejected;
use hisorange\BrowserDetect\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

class CryptoPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $sells = Sell::all();
        return view('admin.crypto-pays.index', compact('sells'));
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
     * @param  \App\Models\CryptoPay  $cryptoPay
     * @return \Illuminate\Http\Response
     */
    public function show(CryptoPay $cryptoPay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CryptoPay  $cryptoPay
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(CryptoPay $cryptoPay)
    {
        if($cryptoPay->gateway_id == 1)
        {
            $transaction = $this->btcChecker($cryptoPay->txhash);
        } elseif($cryptoPay->gateway_id == 2)
        {
            $transaction = $this->ethChecker($cryptoPay->txhash);
        } elseif($cryptoPay->gateway_id == 3)
        {
            $transaction = $this->usdtErc20Check($cryptoPay->txhash);
        } else {
            $transaction = null;
        }
        return view('admin.crypto-pays.edit',compact('cryptoPay','transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CryptoPay  $cryptoPay
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CryptoPayUpdateRequest $request, CryptoPay $cryptoPay)
    {
        $validatedData = $request->validated();
        $validatedData["total"] = $validatedData["amount"] * $validatedData["price"];

        try {
//            dd(Arr::only($validatedData,
//                [
//                    'amount','price','total','user_note','admin_note'
//                ]));
            Sell::find($cryptoPay->sells->id)->update($validatedData);
            CryptoPay::find($cryptoPay->id)->update($validatedData);
            return back()->with('success', __('The payment successfully updated!'));
        } catch (\Exception $e) {
            return back()->with('error', __('Payment could not be updated!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CryptoPay  $cryptoPay
     * @return \Illuminate\Http\Response
     */
    public function destroy(CryptoPay $cryptoPay)
    {
        //
    }

    public function rejectPay(Request $request)
    {
        if(Sell::find($request->rejectId))
        {
            $sell = Sell::find($request->rejectId);
            if($sell->status == 'confirmed')
            {
                try {
                    //  subtract amount from balance
                    app('App\Http\Controllers\SellController')->subBalance($sell->user_id,$sell->amount);
                    $msg = __("Balance removed from wallet");

                    //  subtract bonus earnings
                    if ($sell->bonus_earning)
                    {
                        app(BonusEarningsController::class)->subBonus($sell->id);
                    }

                    //  subtract referral earnings
                    if (count($sell->referral_earnings))
                    {
                        app(ReferralEarningsController::class)->subReferralEarning($sell->id);
                    }

                } catch (Exception $e)
                {
                    $msg = __("The balance could not be removed from the wallet! Contact with admin");
                }
            }
            //  REJECT PAYMENT
            if($request->rejectNote)
            {
                $sell->update([
                    'admin_note' => $request->rejectNote,
                ]);
            } else {
                $request->rejectNote = null;
            }
            $sell->update([
                'status' => 'rejected'
            ]);

            //  SEND NOTIFICATION TO USER
            dispatch(function () use($sell, $request) {
                User::find($sell->user_id)->notify(new PaymentRejected($request->rejectNote));
                activity('payment-rejected')
                    ->causedBy(\auth()->user())
                    ->withProperties([
                        'status'=>'success',
                        'interface'=>'web',
                        'IP' => request()->ip(),
                        'platform' => \Browser::platformName(),
                        'browser' => \Browser::browserFamily(),
                    ])
                    ->log('Payment Request Rejected');
            })->afterResponse();

            $msg = $msg ? '. ' . $msg : null;
            return back()->with('success', __('Payment successfully rejected') . $msg);
        } else {
            return back()->withErrors(__('Payment could not be declined'));
        }
    }

    public function confirmPay(Request $request)
    {
        if(Sell::find($request->confirmId))
        {
            $sell = Sell::find($request->confirmId);
            if($sell->status != 'confirmed')
            {
                //  ADD AMOUNT TO BALANCE
                try {
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
                } catch (Exception $e)
                {
                    $msg = __(" The balance could not be added to the wallet! Contact with admin");
                }
            }
            // CONFIRM PAYMENT
            if($request->confirmNote)
            {
                $sell->update([
                    'admin_note' => $request->confirmNote,
                ]);
            } else {
                $request->confirmNote = null;
            }
            $sell->update([
                'status' => 'confirmed'
            ]);

            //  SEND NOTIFICATION TO USER
            dispatch(function () use($sell, $request) {
                User::find($sell->user_id)->notify(new PaymentConfirmed($request->confirmNote));

                activity('payment-confirmed')
                    ->causedBy(\auth()->user())
                    ->withProperties([
                        'status'=>'success',
                        'interface'=>'web',
                        'IP' => request()->ip(),
                        'platform' => \Browser::platformName(),
                        'browser' => \Browser::browserFamily(),
                    ])
                    ->log('Payment Request Confirmed');
            })->afterResponse();

            $msg = $msg ? '. ' . $msg : null;
            return back()->with('success', __('Payment successfully confirmed') . $msg);
        } else {
            return back()->withErrors(__('Payment could not be confirmed'));
        }
    }

    public function btcChecker($txhash)
    {
        $apiUrl = 'https://chain.api.btc.com/v3/tx/';
        $btcWallet = CryptoGateway::find(1)->val1;
        $return = [];
        try {
            $json = file_get_contents($apiUrl.$txhash.'?verbose=2');
            $data = json_decode($json,true);
            if (isset($data['data']['outputs'])){
                $return['txhash'] = 'found';
                foreach ($data['data']['outputs'] as $output)
                {
                    if($output['addresses'][0]==$btcWallet)
                    {
                        $return['receiver'] = 'found';
                        $return['value'] = $output['value']/100000000;
                        break;
                    } else {
                        $return['receiver'] = 'error';
                    }
                }
                $return['sender'] = $data['data']['inputs']['prev_addresses'][0];
                $return['confirmations'] = $data['data']['confirmations'];
                $return['time'] = $data['data']['block_time'];
            } else {
                $return['txhash'] = 'error';
            }
        } catch (\Exception $e) {
            $return['txhash'] = 'error';
        }
        $return['powered'] = 'Powered by Btc.com';
        return $return;
    }

    public function ethChecker($txhash)
    {
        $apiUrl = 'https://api.etherscan.io/api?module=account&action=txlist&address=';
        $apiKey = 'QSJ4AY22YT53ABYSWZJ1UQTZ19EIB3IQFT';
        $ethWallet = CryptoGateway::find(2)->val1;
        $return = [];
        try {
            $json = file_get_contents($apiUrl.$ethWallet.'&sort=desc&apikey='.$apiKey);
            $data = json_decode($json,true);
            $result = $data['result'];
            foreach ($result as $trx)
            {
                if($trx['hash']==$txhash)
                {
                    $return['txhash'] = 'found';
                    $return['sender'] = $trx['from'];
                    if($trx['to']==$ethWallet)
                    {
                        $return['receiver'] = 'found';
                    } else {
                        $return['receiver'] = 'error';
                    }
                    $return['value'] = $trx['value']/18;
                    $return['confirmations'] = $trx['confirmations'];
                    $return['time'] = $trx['timeStamp'];
                } else {
                    $return['txhash'] = 'error';
                }
            }
        } catch (\Exception $e) {
            $return['txhash'] = 'error';
        }
        $return['powered'] = 'Powered by EtherScan.io';
        return $return;
    }

    public function usdtErc20Check($txhash)
    {
        $apiUrl = 'https://api.etherscan.io/api?module=account&action=txlist&address=';
        $apiKey = 'QSJ4AY22YT53ABYSWZJ1UQTZ19EIB3IQFT';
        $ethWallet = CryptoGateway::find(3)->val1;
        $return = [];
        try {
            $json = file_get_contents($apiUrl.$ethWallet.'&sort=desc&apikey='.$apiKey);
            $data = json_decode($json,true);
            $result = $data['result'];
            foreach ($result as $trx)
            {
                if($trx['hash']==$txhash)
                {
                    $return['txhash'] = 'found';
                    $return['sender'] = $trx['from'];
                    if($trx['to']==$ethWallet)
                    {
                        $return['receiver'] = 'found';
                    } else {
                        $return['receiver'] = 'error';
                    }
                    $return['value'] = $trx['value']/18;
                    $return['confirmations'] = $trx['confirmations'];
                    $return['time'] = $trx['timeStamp'];
                } else {
                    $return['txhash'] = 'error';
                }
            }
        } catch (\Exception $e) {
            $return['txhash'] = 'error';
        }
        $return['powered'] = 'Powered by EtherScan.io';
        return $return;
    }
}
