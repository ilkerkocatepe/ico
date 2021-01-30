<?php

namespace App\Http\Controllers;

use App\Http\Requests\CryptoPayUpdateRequest;
use App\Models\CryptoGateway;
use App\Models\CryptoPay;
use hisorange\BrowserDetect\Exceptions\Exception;
use Illuminate\Http\Request;

class CryptoPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $sells = CryptoPay::all();
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
        } elseif($cryptoPay->gateway_id == 2){

            $transaction = $this->ethChecker($cryptoPay->txhash);
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
        if(CryptoPay::find($request->rejectId))
        {
            $payment = CryptoPay::find($request->rejectId);
            if($payment->status == 'confirmed')
            {
                // subtract amount from balance
                try {
                    app('App\Http\Controllers\SellController')->subBalance($payment->user_id,$payment->amount);
                    $msg = __("Balance removed from wallet");
                } catch (Exception $e)
                {
                    $msg = __("The balance could not be removed from the wallet! Contact with admin");
                }
            }
            // reject payment
            if($request->rejectNote)
            {
                $payment->update([
                    'admin_note' => $request->rejectNote,
                ]);
            }
            $payment->update([
                'status' => 'rejected'
            ]);
            $msg = $msg ? '. ' . $msg : null;
            return back()->with('success', __('Payment successfully rejected') . $msg);
        } else {
            return back()->withErrors(__('Payment could not be declined'));
        }
    }

    public function confirmPay(Request $request)
    {
        if(CryptoPay::find($request->confirmId))
        {
            $payment = CryptoPay::find($request->confirmId);
            if($payment->status == 'rejected')
            {
                // add amount to balance
                try {
                    app('App\Http\Controllers\SellController')->addBalance($payment->user_id,$payment->amount);
                    $msg = __(" Balance added to wallet");
                } catch (Exception $e)
                {
                    $msg = __(" The balance could not be added to the wallet! Contact with admin");
                }
            }
            // confirm payment
            if($request->confirmNote)
            {
                $payment->update([
                    'admin_note' => $request->confirmNote,
                ]);
            }
            $payment->update([
                'status' => 'confirmed'
            ]);
            $msg = $msg ? '. ' . $msg : null;
            return back()->with('success', __('Payment successfully confirmed') . $msg);
        } else {
            return back()->withErrors(__('Payment could not be confirmed'));
        }
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
}
