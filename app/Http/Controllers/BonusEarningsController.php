<?php

namespace App\Http\Controllers;

use App\Models\BonusEarnings;
use App\Models\Sell;
use App\Models\Stage;
use App\Notifications\User\BonusEarning;
use Illuminate\Http\Request;

class BonusEarningsController extends Controller
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
     * @param  \App\Models\BonusEarnings  $bonusEarnings
     * @return \Illuminate\Http\Response
     */
    public function show(BonusEarnings $bonusEarnings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BonusEarnings  $bonusEarnings
     * @return \Illuminate\Http\Response
     */
    public function edit(BonusEarnings $bonusEarnings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BonusEarnings  $bonusEarnings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonusEarnings $bonusEarnings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BonusEarnings  $bonusEarnings
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonusEarnings $bonusEarnings)
    {
        //
    }


    public function addBonus($sell_id)
    {
        $sell = Sell::findOrFail($sell_id);

        // BONUS RECORD
        $bonus_amount = Stage::activeStage()->bonus_rate * $sell->amount / 100;

        //  Firstly, check available token amount
        if (app(SellController::class)->checkRemain($bonus_amount))
        {
            $bonus = BonusEarnings::create([
                'stage_id' => $sell->stage->id,
                'user_id' => $sell->user->id,
                'sell_id' => $sell->id,
                'purchase_amount' => $sell->amount,
                'bonus_rate' => Stage::activeStage()->bonus_rate,
                'bonus_amount' => app(SellController::class)->checkRemain($bonus_amount)
            ]);

            //  ADD BONUS TO WALLET
            app(SellController::class)->addBalance($sell->user->id, $bonus_amount);

            // NOTIFICATION
            $sell->user->notify(new BonusEarning($bonus));
        }
    }

    public function subBonus($sell_id)
    {
        $sell = Sell::findOrFail($sell_id);
        $bonus_earning = $sell->bonus_earning;

        //  SUBTRACT BONUS FROM WALLET
        app(SellController::class)->subBalance($sell->user->id, $bonus_earning->bonus_amount);

        //  DELETE BONUS RECORD
        $bonus_earning->delete();
    }
}
