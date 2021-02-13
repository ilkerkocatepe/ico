<?php

namespace App\Http\Controllers;

use App\Models\Sell;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $sells = Sell::all();
        return view('admin.sells.index', compact('sells'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function addBalance($user_id, $amount)
    {
        $wallet = User::find($user_id)->wallet;
        $balance = $wallet->balance;

        $amount = $this->checkRemain($amount);
        $wallet->update([
            'balance' => $balance + $amount
        ]);
    }

    public function checkRemain($amount)
    {
        if ($amount > Stage::activeRemain())
        {
            $amount = Stage::activeRemain();
        }
        return $amount;
    }

    public function subBalance($user_id, $amount)
    {
        $wallet = User::find($user_id)->wallet;
        $balance = $wallet->balance;
        $wallet->update([
            'balance' => $balance - $amount
        ]);

    }
}
