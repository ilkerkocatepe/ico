<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalWalletRequest;
use App\Models\ExternalWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExternalWalletController extends Controller
{
    public $externalWallet;

    public function __construct(ExternalWallet $externalWallet)
    {
        if($externalWallet->user_id == Auth::id())
        {
            $this->externalWallet = $externalWallet;
        } else {
            return back()->with('error', __('External wallet could not be found!'));
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.external-wallets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.external-wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExternalWalletRequest $request)
    {
        $validatedData = $request->validated();

        if (isset($validatedData['status']))
        {
            if ($validatedData['status'] == 'checked')
            {
                $validatedData['status'] = '1';
            } else {
                $validatedData['status'] = '0';
            }
        } else {
            $validatedData['status'] = '0';
        }

        $validatedData['user_id'] = auth()->id();

        try {
            ExternalWallet::create($validatedData);
            return redirect()->route('user.external-wallets.index')->with('success', __('Your external wallet successfully created!'));
        } catch (\Exception $e) {
            return back()->with('error', __('External wallet could not be created!'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExternalWallet  $externalWallet
     * @return \Illuminate\Http\Response
     */
    public function show(ExternalWallet $externalWallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExternalWallet  $externalWallet
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit(ExternalWallet $externalWallet)
    {
        if($externalWallet->user_id == Auth::id())
        {
            return view('user.external-wallets.edit', compact('externalWallet'));
        } else {
            return redirect()->route('user.external-wallets.index')->with('error', __('External wallet could not be found!'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExternalWallet  $externalWallet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExternalWalletRequest $request, ExternalWallet $externalWallet)
    {
        $validatedData = $request->validated();

        if (isset($validatedData['status']))
        {
            if ($validatedData['status'] == 'checked')
            {
                $validatedData['status'] = '1';
            } else {
                $validatedData['status'] = '0';
            }
        } else {
            $validatedData['status'] = '0';
        }

        try {
            ExternalWallet::find($externalWallet->id)->update($validatedData);
            return back()->with('success', __('The external wallet successfully updated!'));
        } catch (\Exception $e) {
            return back()->with('error', __('External wallet could not be updated!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExternalWallet  $externalWallet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ExternalWallet $externalWallet)
    {
        if(!$externalWallet->user_id == Auth::id())
        {
            return redirect()->route('user.external-wallets.index')->with('error', __('External wallet could not be found!'));
        }
        try {
            $externalWallet->delete();
            return redirect()->route('user.external-wallets.index')->with('success', __('The external wallet successfully deleted!'));
        } catch (\Exception $e) {
            return back()->with('error', __('The external wallet could not be deleted!'));
        }
    }

    public function enable(ExternalWallet $externalWallet)
    {
        if(!$externalWallet->user_id == Auth::id())
        {
            return redirect()->route('user.external-wallets.index')->with('error', __('External wallet could not be found!'));
        }
        try {
            $externalWallet->update(['status'=>'1']);
            return back()->with('success', __('The external wallet successfully enabled!'));
        } catch (\Exception $e) {
            return back()->with('error', __('The external wallet could not be enabled!'));
        }
    }

    public function disable(ExternalWallet $externalWallet)
    {
        if(!$externalWallet->user_id == Auth::id())
        {
            return redirect()->route('user.external-wallets.index')->with('error', __('External wallet could not be found!'));
        }
        try {
            $externalWallet->update(['status'=>'0']);
            return back()->with('success', __('The external wallet successfully disabled!'));
        } catch (\Exception $e) {
            return back()->with('error', __('The external wallet could not be disabled!'));
        }
    }
}
