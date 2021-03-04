@extends('layouts.admin.master')
@section('title')
    {{__('New Bank Payment')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('New Bank Payment')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-warning" href="{{ route('admin.bank-pays.index') }}"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
@endsection
@section('content')
    <section id="create_bank_pay" class="app-user-view">
        @include('layouts.admin.errors')
        <div class="row invoice-edit">
            <div class="col-12">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <form action="{{ route('admin.bank-pays.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="stage">{{ __('Stage') }}</label>
                                        <select class="form-control" id="stage" name="stage" required>
                                            @foreach(\App\Models\Stage::all() as $stage)
                                                <option @if(old('stage')==$stage->id) selected @endif value="{{ $stage->id }}">{{ $stage->name }} - ${{ $stage->fixed_price }} | {{ $stage->status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="gateway">{{ __('Gateway') }}</label>
                                        <select class="form-control" id="gateway" name="gateway" required>
                                            @foreach(\App\Models\BankGateway::all() as $gateway)
                                                <option @if(old('gateway')==$gateway->id) selected @endif value="{{ $gateway->id }}">{{__('Name')}}: {{ $gateway->name }} | {{__('Type')}}: {{ $gateway->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="user">{{ __('User') }}</label>
                                        <select class="form-control" id="user" name="user" required>
                                            @foreach(\App\Models\User::all() as $user)
                                                <option @if(old('user')==$user->id) selected @endif value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="deposit_amount">{{ __('Deposit Amount') }}*</label>
                                        <input type="number" min="1" id="deposit_amount" class="form-control" name="deposit_amount" placeholder="{{ __('Deposit Amount') }}" value="{{old('deposit_amount')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="rate">{{ __('Currency Rate') }}*</label>
                                        <input type="number" min="1" id="rate" class="form-control" name="rate" placeholder="{{ __('Currency Rate (1 for USD)') }}" value="{{old('rate')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="deposit_value">{{ __('Deposit Value') }}*</label>
                                        <input type="number" min="1" id="deposit_value" class="form-control" name="deposit_value" placeholder="{{ __('Deposit Value') }}" value="{{old('deposit_value')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="user_note">{{ __('User Note') }}</label>
                                        <textarea id="user_note" class="form-control" name="user_note" placeholder="{{ __('User Note') }}">{{ old('user_note') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="admin_note">{{ __('Admin Note') }}</label>
                                        <textarea id="admin_note" class="form-control" name="admin_note" placeholder="{{ __('Admin Note') }}">{{ old('admin_note') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mx-auto">
                                <div class="col-12 text-center">
                                    <button type="reset" class="btn btn-warning mt-75">
                                        <i class="fa fa-redo"></i>
                                        {{__('Reset')}}
                                    </button>
                                    <button type="submit" class="btn btn-primary mt-75">
                                        <i class="fa fa-save"></i>
                                        {{__('Save')}}
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
