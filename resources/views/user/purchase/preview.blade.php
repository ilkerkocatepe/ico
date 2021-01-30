
@extends('layouts.user.master')
@section('title')
    {{__('Purchase Preview')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('Purchase Preview')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i> {{ __('Dashboard') }}</a>
@endsection
@section('content')

    <section id="purchase-preview">
        <div class="row invoice-edit">
            <div class="col-xl-12 col-md-12 col-12">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <form action="{{ route('user.purchase.confirm') }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="gateway" value="{{$gateway}}"/>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="amount">{{ __('Amount') }}</label>
                                        <input type="text" id="amount" class="form-control" name="amount" value="{{$amount}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="price">{{ __('Price') }}</label>
                                        <input type="text" id="price" class="form-control" value="{{$price}}" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="total">{{ __('Total Value') }}</label>
                                        <input type="text" id="total" class="form-control" value="{{$total}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="value">{{ __('Payment Method Market Value') }}</label>
                                        <input type="text" id="value" class="form-control" value="{{$value}}" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if($bonus!=0)
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bonus">{{ __('Bonus') }}</label>
                                                <input type="text" id="bonus" class="form-control" value="{{$bonus}}" readonly/>
                                            </div>
                                        </div>
                                @endif
                                <div class="col-md-6 col-12">
                                    <label for="payable">{{ __('Payable') }}</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="payable" class="form-control" value="{{$payable}}" readonly/>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" id="copy_payable">{{__('Copy')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="external_wallet_name">{{ __('Sender Wallet') }}</label>
                                        <input type="hidden" name="external_wallet" value="{{$external_wallet}}">
                                        <input type="text" id="external_wallet_name" class="form-control" value="{{ \App\Models\ExternalWallet::find($external_wallet)->name }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="wallet">{{ __('Receiver Wallet') }}</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="wallet" class="form-control" value="{{$wallet}}" readonly/>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" id="copy_wallet">{{__('Copy')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h4 class="text-center">
                                        {{ __('Please firstly, send') }}&nbsp;
                                        <span class="text-primary">{{ $payable }}&nbsp;{{ $type }}</span>&nbsp;
                                        {{ __('to') }}&nbsp;
                                        <span class="text-primary">{{ $wallet }}</span>&nbsp;
                                        {{ __('from') }}&nbsp;
                                        <span class="text-primary">{{ \App\Models\ExternalWallet::find($external_wallet)->address }}</span>&nbsp;
                                    </h4>
                                    <h5 class="text-center mt-2">
                                        {{ __('After the transfer, enter your transfer code(TX HASH) below.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="user_note">{{__('User Note')}}</label>
                                        <input id="user_note" name="user_note" class="form-control" type="text" placeholder="{{__('You can type a note to administration.(Not Required)')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="txhash">TX HASH *</label>
                                        <input id="txhash" name="txhash" class="form-control form-control-lg" type="text" placeholder="{{__('Please enter the TX HASH code of your transfer')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn btn-primary waves-effect waves-float waves-light mx-auto">{{ __('Send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('page-scripts')
    <script>
        var userText = $("#wallet"),
            btnCopy = $("#copy_wallet");
        btnCopy.on("click", function() {
            userText.select(),
                document.execCommand("copy"),
                toastr.success("", "{{__('Copied to clipboard!')}}")
        });
        var userText2 = $("#payable"),
            btnCopy2 = $("#copy_payable");
        btnCopy2.on("click", function() {
            userText2.select(),
                document.execCommand("copy"),
                toastr.success("", "{{__('Copied to clipboard!')}}")
        });
    </script>
@endsection
