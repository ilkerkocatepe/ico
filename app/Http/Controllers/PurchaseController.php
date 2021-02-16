<?php

namespace App\Http\Controllers;

use App\Models\CryptoGateway;
use App\Models\CryptoPay;
use App\Models\ExternalWallet;
use App\Models\Sell;
use App\Models\Stage;
use App\Models\User;
use App\Notifications\Admin\PaymentReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Notification;
use Spatie\Activitylog\Models\Activity;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getStageInfo()
    {
        $stage = Stage::findOrFail(\request()->stage);

        if($stage->max_buy)
        {
            if($stage->max_buy > $stage->remain())
            {
                $max_buy = $stage->remain();
            } else {
                $max_buy = $stage->max_buy;
            }
        } else {
            $max_buy = $stage->remain();
        }

        if($stage->min_buy)
        {
            $min_buy = $stage->min_buy;
        } else {
            $min_buy = 1;
        }

        return response()->json(['min_buy'=>$min_buy,'max_buy'=>$max_buy,'price'=>$stage->fixed_price]);
    }

    public function getBonusInfo()
    {
        $stage = Stage::findOrFail(\request()->stage);

        return response()->json(['status'=>intval($stage->bonus_status),'min_for_bonus'=>$stage->bonus_minimum,'bonus_rate'=>$stage->bonus_rate]);
    }

    public function getMarketInfo()
    {
        $gateway = CryptoGateway::findOrFail(\request()->gateway);

        if($gateway->id == 1)
        {
            // BTC
            $value = $this->selectedMarketValue(1);
            return response()->json(['symbol'=>$gateway->symbol,'value'=>$value,'decimal'=>$gateway->confirm_decimal,'type'=>$gateway->type]);
        } elseif($gateway->id == 2)
        {
            // ETH
            $value = $this->selectedMarketValue(2);
            return response()->json(['symbol'=>$gateway->symbol,'value'=>$value,'decimal'=>$gateway->confirm_decimal,'type'=>$gateway->type]);
        } elseif($gateway->id == 3)
        {
            // USDT ERC20
            $value = $this->selectedMarketValue(3);
            return response()->json(['symbol'=>$gateway->symbol,'value'=>$value,'decimal'=>$gateway->confirm_decimal,'type'=>$gateway->type]);
        } else {
            return response()->json(['message'=>'There is an error!']);
        }

    }

    public function selectedMarketValue($id)
    {
        switch ($id){
            case 1: return $this->getBTCValue();
            case 2: return $this->getETHValue();
            case 3: return 1;
        }
    }

    public function getBTCValue()
    {
        $json = file_get_contents('https://api-pub.bitfinex.com/v2/ticker/tBTCUSD');
        $data = json_decode($json,true);
        return intval($data[6]);
    }
    public function getETHValue()
    {
        $json = file_get_contents('https://api-pub.bitfinex.com/v2/ticker/tETHUSD');
        $data = json_decode($json,true);
        return intval($data[6]);
    }

    public function prepare(Request $request)
    {
        $validatedData = $request->validate([
            'form_gateway' => ['required', 'integer'],
            'form_external_wallet' => ['required', 'integer'],
            'purchase_amount' => ['required', 'integer'],
            'method_value' => ['required', 'numeric'],
        ]);

        $external_wallet = $validatedData['form_external_wallet'];
        $price = Stage::activePrice();
        $stage = Stage::activeStage();
        try {
            $gateway = CryptoGateway::findOrFail($validatedData['form_gateway']);
            if(!$gateway->status)
            {
                return back()->with(['error'=>__('The gateway is not enabled')]);
            }
            if(!ExternalWallet::findOrFail($validatedData['form_external_wallet'])->status)
            {
                return back()->with(['error'=>__('The external wallet is not enabled')]);
            }
            $amount = $this->amountCheck($validatedData['purchase_amount']);

            $bonus=0;
            if($stage->bonus_status)
            {
                if($amount>= $stage->bonus_minimum)
                {
                    $bonus = $this->bonusCalculate($amount, $stage->bonus_rate);
                }
            }

            $total = $price * $amount;

            if($validatedData['form_gateway'] == 1)
            {
                // BTC
                $value = $this->selectedMarketValue(1);
                $symbol = CryptoGateway::find(1)->symbol;
                $decimal = CryptoGateway::find(1)->confirm_decimal;
            } elseif($validatedData['form_gateway'] == 2)
            {
                // ETH
                $value = $this->selectedMarketValue(2);
                $symbol = CryptoGateway::find(2)->symbol;
                $decimal = CryptoGateway::find(2)->confirm_decimal;
            } elseif($validatedData['form_gateway'] == 3)
            {
                // USDT ERC20
                $value = $this->selectedMarketValue(3);
                $symbol = CryptoGateway::find(3)->symbol;
                $decimal = CryptoGateway::find(3)->confirm_decimal;
            } else {
                return back()->with(['error'=>'There is an error. Contact with support!']);
            }
            $gateway=$validatedData['form_gateway'];
            $wallet = $this->walletAddress($validatedData['form_gateway']);
            $payable = number_format(($amount * $price / $value), $decimal);
            return view('user.purchase.preview',compact('amount','price','total','bonus','value','payable','external_wallet','wallet','symbol','gateway'));
        } catch (\Exception $e)
        {
            return back()->with(['error'=>__('An error occurred. Refresh the page and try again.')]);
        }
    }

    public function walletAddress($gateway)
    {
        $address = CryptoGateway::findOrFail($gateway)->val1;
        if(Hash::check($address, CryptoGateway::findOrFail($gateway)->val4))
        {
            return $address;
        } else {
            return __('There is a problem with the wallet. Please contact with project management.');
        }
    }

    public function amountCheck($amount)
    {
        $stage = Stage::activeStage();
        $remain = Stage::activeRemain();

        if($amount <= $remain)
        {
            if($stage->min_buy)
            {
                if($amount < $stage->min_buy)
                {
                    $amount = $stage->min_buy;
                }
            }
            if($stage->max_buy)
            {
                if($amount > $stage->max_buy)
                {
                    $amount = $stage->max_buy;
                }
            }
        } else {
            $amount = $remain;
        }
        return $amount;
    }

    public function bonusCalculate($amount, $rate)
    {
        return $amount * $rate / 100;
    }

    public function confirm(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => ['required', 'integer'],
            'external_wallet' => ['required', 'integer'],
            'gateway' => ['required', 'string'],
            'txhash' => ['required', 'string'],
            'user_note' => ['nullable', 'string'],
        ]);
        $amount = $this->amountCheck($validatedData['amount']);
        $external_wallet = $validatedData['external_wallet'];
        $gateway = $validatedData['gateway'];

        try {
            $payment = CryptoPay::create([
                'gateway_id' => $gateway,
                'external_wallet_id' => $external_wallet,
                'payable' => number_format(Stage::activePrice() * $amount/$this->selectedMarketValue($gateway), CryptoGateway::find($gateway)->confirm_decimal, '.', ''),
                'current_value' => $this->selectedMarketValue($gateway) ?? 0,
                'txhash' => $validatedData['txhash'],
            ]);

            Sell::create([
                'user_id' => Auth::id(),
                'stage_id' => Stage::activeStage()->id,
                'method_id' => '1',
                'sellable_id' => $payment->getKey(),
                'sellable_type' => $payment->getMorphClass(),
                'amount' => $amount,
                'price' => Stage::activePrice(),
                'total' => Stage::activePrice() * $amount,
                'user_note' => $validatedData['user_note'],
                'status' => 'pending',
            ]);

            //  CREATE EVENT
            \App\Events\PaymentReceived::dispatch($payment);

            return redirect()->route('user.tokens')->with(['success'=>__('Your payment process has been successfully completed!')]);
        } catch(\Exception $e)
        {
            return back()->with(['error'=>__('Your payment process has failed')]);
        }
    }

    public function cancel()
    {
        $id = \request()->id;
        if(Auth::id() != Sell::findOrFail($id)->user_id)
        {
            return response()->json(['message' => __('Purchase request could not find!')]);
        }
        if (! Hash::check(\request()->password, Auth::user()->password)) {
            return response()->json(['message' => __('The given password does not match!')]);
        }

        try {
            $purchase = Sell::findOrFail($id);
            $purchase->status = 'canceled';
            $purchase->save();
            return response()->json(['success' => __('The purchase canceled successfully!')]);
        } catch (\Exception $e)
        {
            return response()->json(['message' => __('The purchase could not canceled!')]);
        }
    }
}
