@extends('layouts.admin.master')
@section('title')
    {{__('Payment Preview')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('Payment Preview')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-warning" href="javascript:history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
@endsection
@section('content')
    <section id="create_bank_pay" class="app-user-view">
        @include('layouts.admin.errors')
        <div class="row invoice-edit">
            <div class="col-12">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <form action="{{ route('admin.bank-pays.confirm') }}" method="post">
                            @csrf
                            <input type="hidden" name="stage_id" value="{{$request->stage}}">
                            <input type="hidden" name="gateway_id" value="{{$request->gateway}}">
                            <input type="hidden" name="user_id" value="{{$request->user}}">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="stage">{{ __('Stage') }}</label>
                                        @php($stage=\App\Models\Stage::findOrFail($request->stage))
                                        <input class="form-control" type="text" id="stage" value="{{ $stage->name }} - ${{ $stage->fixed_price }} | {{ $stage->status }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="gateway">{{ __('Gateway') }}</label>
                                        @php($gateway=\App\Models\BankGateway::findOrFail($request->gateway))
                                        <input class="form-control" type="text" id="gateway" value="{{__('Name')}}: {{ $gateway->name }} | {{__('Type')}}: {{ $gateway->type }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="user">{{ __('User') }}</label>
                                        @php($user=\App\Models\User::findOrFail($request->user))
                                        <input class="form-control" type="text" id="user" value="{{ $user->name }} - {{ $user->email }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="deposit_amount">{{ __('Deposit Amount') }}*</label>
                                        <input type="number" min="1" id="deposit_amount" class="form-control" name="deposit_amount" placeholder="{{ __('Deposit Amount') }}" value="{{$request->deposit_amount}}" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="rate">{{ __('Currency Rate') }}*</label>
                                        <input type="number" min="1" id="rate" class="form-control" name="rate" placeholder="{{ __('Currency Rate (1 for USD)') }}" value="{{$request->rate}}" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="deposit_value">{{ __('Deposit Value') }}*</label>
                                        <input type="number" min="1" id="deposit_value" class="form-control" name="deposit_value" placeholder="{{ __('Deposit Value') }}" value="{{$request->deposit_value}}" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="user_note">{{ __('User Note') }}</label>
                                        <textarea id="user_note" class="form-control" name="user_note" placeholder="{{ __('User Note') }}" readonly>{{ $request->user_note }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="admin_note">{{ __('Admin Note') }}</label>
                                        <textarea id="admin_note" class="form-control" name="admin_note" placeholder="{{ __('Admin Note') }}" readonly>{{ $request->admin_note }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" id="token_amount" class="form-control form-control-lg text-center" value="{{__('Token Amount')}}: {{$request->token_amount ?? 0}} {{ $tokenSymbol }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mx-auto">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success mt-75">
                                        <i class="fa fa-check"></i>
                                        {{__('Confirm')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-scripts')

@endsection
