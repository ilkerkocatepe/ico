@extends('layouts.user.master')
@section('title')
    {{__('External Wallet')}}: {{ $externalWallet->name }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice.css') }}">
@endsection
@section('header_title')
    {{__('External Wallet')}}: <span class="text-primary">{{ $externalWallet->name }}</span>
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('user.external-wallets.index') }}"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
@endsection
@section('content')

    <section class="invoice-edit-wrapper">
        @include('layouts.user.errors')
        <form class="form" method="post" action="{{ route('user.external-wallets.update',$externalWallet) }}">
            @method('PUT')
            @csrf
            <div class="row invoice-edit">
                <div class="col-xl-9 col-md-8 col-12">
                    <div class="card invoice-preview-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Wallet Name') }}*</label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Wallet Name') }}" value="{{ $externalWallet->name }}" required/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="description">{{ __('Wallet Description') }}</label>
                                        <input type="text" id="description" class="form-control" name="description" placeholder="{{ __('Wallet Description') }}" value="{{ $externalWallet->description }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="type">{{ __('Wallet Type') }}</label>
                                        <select class="form-control" name="type" id="type">
                                            <option @if($externalWallet->type=='BTC') selected @endif value="BTC">BTC</option>
                                            <option @if($externalWallet->type=='ETH') selected @endif value="ETH">ETH</option>
                                            <option @if($externalWallet->type=='USDT_Omni') selected @endif value="USDT_Omni">USDT (Omni)</option>
                                            <option @if($externalWallet->type=='USDT_ERC20') selected @endif value="USDT_ERC20">USDT (ERC20)</option>
                                            <option @if($externalWallet->type=='LTC') selected @endif value="LTC">LTC</option>
                                            <option @if($externalWallet->type=='XRP') selected @endif value="XRP">XRP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="address">{{ __('Wallet Address') }}*</label>
                                        <input type="text" id="address" class="form-control" name="address" placeholder="{{ __('Wallet Address') }}" value="{{ $externalWallet->address }}" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mt-1">
                                <label class="invoice-terms-title mb-1" for="bonus">{{__('Wallet Status')}}</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" value="checked" @if($externalWallet->status=='1') checked @endif/>
                                    <label class="custom-control-label" for="status"></label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block my-75">
                                <i class="fa fa-save"></i>
                                {{__('Save')}}
                            </button>
                            <button type="reset" class="btn btn-warning btn-block mb-75">
                                <i class="fa fa-redo"></i>
                                {{__('Reset')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection
@section('page-scripts')
    <script src="{{ asset('app-assets/js/scripts/pages/app-invoice.js') }}"></script>
@endsection

