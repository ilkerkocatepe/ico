<?php

namespace App\Http\Controllers;

use App\Models\ReferenceLevel;
use App\Models\ReferralEarnings;
use App\Models\Sell;
use App\Models\User;
use App\Notifications\User\ReferralEarning;
use Illuminate\Http\Request;

class ReferralEarningsController extends Controller
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
     * @param  \App\Models\ReferralEarnings  $referralEarnings
     * @return \Illuminate\Http\Response
     */
    public function show(ReferralEarnings $referralEarnings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReferralEarnings  $referralEarnings
     * @return \Illuminate\Http\Response
     */
    public function edit(ReferralEarnings $referralEarnings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReferralEarnings  $referralEarnings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReferralEarnings $referralEarnings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReferralEarnings  $referralEarnings
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReferralEarnings $referralEarnings)
    {
        //
    }

    public function addReferralEarning($sell_id)
    {
        $sell = Sell::findOrFail($sell_id);
        $sender_user = $sell->user;

        foreach (ReferenceLevel::all()->sortBy('level') as $level)
        {
            //  SET REFERRAL USER
            $receiver_user = $sender_user->parent;
            if ($receiver_user->balance() >= $level->min_balance)
            {
                //  AMOUNT CALCULATE
                $amount = $this->calculate($level,$sell->amount);

                //  Firstly, check available token amount
                $amount = app(SellController::class)->checkRemain($amount);

                if ($amount)
                {
                    //  CREATE RECORD
                    $referral_earning = ReferralEarnings::create([
                        'stage_id' => $sell->stage->id,
                        'user_id' => $receiver_user->id,
                        'referral_id' => $sender_user->id,
                        'sell_id' => $sell->id,
                        'amount' => $amount,
                        'level' => $level->level,
                    ]);

                    //  ADD BALANCE TO WALLET
                    app(SellController::class)->addBalance($receiver_user->id, $amount);

                    // NOTIFICATION
                    $receiver_user->notify(new ReferralEarning($referral_earning));
                }
            }

            //  SET REFERRAL AS NEW USER
            if($receiver_user->parent)
            {
                $sender_user = $receiver_user;
            } else {
                break;
            }
        }
    }

    public function calculate(ReferenceLevel $level, $amount)
    {
        $earning = $amount * $level->rate / 100;
        if(isset($level->max_earnings)) {
            if ($earning > $level->max_earnings) {
                $earning = $level->max_earnings;
            }
        }
        return $earning;
    }

    public function subReferralEarning($sell_id)
    {
        $sell = Sell::findOrFail($sell_id);

        //  SUBTRACT BALANCES FROM WALLETS
        foreach ($sell->referral_earnings as $earning)
        {
            app(SellController::class)->subBalance($earning->user_id, $earning->amount);
        }

        //  DELETE RECORDS
        ReferralEarnings::where('sell_id',$sell_id)->delete();
    }
}
