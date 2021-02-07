@extends('layouts.user.master')
@section('title')
    {{__('Purchase Tokens')}}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-wizard.css') }}">
@endsection
@section('header_title')
    {{__('Purchase Tokens')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('user.tokens') }}"><i class="fa fa-coins"></i> {{ __('My Tokens') }}</a>
@endsection
@section('content')
    @php($user = \Illuminate\Support\Facades\Auth::user())
    @php($stages = \App\Models\Stage::where('status','running')
        ->where(function ($query){
            $query->whereNull('finished_at')->orWhere('finished_at','>',now());
    })->get())
    @php($methods = \App\Models\PaymentMethod::where('status','1')->with('cryptoGateways')->get())
    @php($payments = $user->payments()->where('status','pending')->get())

    <section class="vertical-wizard">
        <div class="bs-stepper vertical vertical-wizard-example">
            <div class="bs-stepper-header">
                <div class="step" data-target="#purchase-stage">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">1</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{ __('Stage') }}</span>
                            <span class="bs-stepper-subtitle">{{ __('Select stage for buying') }}</span>
                        </span>
                    </button>
                </div>
                <div class="step" data-target="#purchase-method">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{ __('Payment Method') }}</span>
                            <span class="bs-stepper-subtitle">{{ __('Choose a method for payment') }}</span>
                        </span>
                    </button>
                </div>
                <div class="step" data-target="#purchase-external-wallet">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{ __('External Wallet') }}</span>
                            <span class="bs-stepper-subtitle">{{ __('Choose the external wallet to transfer') }}</span>
                        </span>
                    </button>
                </div>
                <div class="step" data-target="#purchase-amount">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{ __('Amount') }}</span>
                            <span class="bs-stepper-subtitle">{{ __('Determine the amount you will purchase') }}</span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <div id="purchase-stage" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">{{ __('Select Stage') }}</h5>
                        <small class="text-muted">{{ __('Select stage for buying') }}</small>
                    </div>
                    <div class="row">
                        @forelse($stages as $stage)
                            <div class="col-lg-1 col-md-1 col-1">
                                <div class="custom-control custom-radio mt-5">
                                    <input type="radio" id="stage{{$stage->id}}" name="stage" class="custom-control-input" value="{{$stage->id}}" @if($loop->first) checked @endif required>
                                    <label class="custom-control-label" for="stage{{$stage->id}}"></label>
                                </div>
                            </div>
                            <div class="col-lg-11 col-md-11 col-11">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title"><div class="badge badge-glow badge-success">{{__('Running')}}</div> {{ $stage->name }}</h4>
                                        <div class="ml-auto">
                                            <p class="card-text text-muted mb-0">{{__('Price')}}</p>
                                            <h3 class="font-weight-bolder mb-0">$ {{ $stage->fixed_price }}</h3>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        @if($stage->min_buy && $stage->max_buy)
                                            <div class="row border-top text-center mx-0">
                                                <div class="col-6 border-right py-1">
                                                    <p class="card-text text-muted mb-0">{{__('Minimum Purchase Amount')}}</p>
                                                    <h3 class="font-weight-bolder mb-0">{{ $stage->min_buy }}</h3>
                                                </div>
                                                <div class="col-6 py-1">
                                                    <p class="card-text text-muted mb-0">{{__('Maximum Purchase Amount')}}</p>
                                                    <h3 class="font-weight-bolder mb-0">{{ $stage->max_buy }}</h3>
                                                </div>
                                            </div>
                                        @endif
                                        @if($stage->hardcap && $stage->softcap)
                                            <div class="row border-top text-center mx-0">
                                                <div class="col-6 border-right py-1">
                                                    <p class="card-text text-muted mb-0">{{__('Soft Cap')}}</p>
                                                    <h3 class="font-weight-bolder mb-0">{{ $stage->softcap }}</h3>
                                                </div>
                                                <div class="col-6 py-1">
                                                    <p class="card-text text-muted mb-0">{{__('Hard Cap')}}</p>
                                                    <h3 class="font-weight-bolder mb-0">{{ $stage->hardcap }}</h3>
                                                </div>
                                            </div>
                                        @endif
                                        @if($stage->bonus_status)
                                            <div class="row border-top text-center mx-0">
                                                <div class="col-6 border-right py-1">
                                                    <p class="card-text text-muted mb-0">{{__('Min. Purchase for Bonus')}}</p>
                                                    <h3 class="font-weight-bolder mb-0">{{ $stage->bonus_minimum }}</h3>
                                                </div>
                                                <div class="col-6 py-1">
                                                    <p class="card-text text-muted mb-0">{{__('Bonus Rate')}}</p>
                                                    <h3 class="font-weight-bolder mb-0">{{ $stage->bonus_rate }} %</h3>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row border-top text-center mx-0">
                                            <div class="col-6 border-right py-1">
                                                <p class="card-text text-muted mb-0">{{__('Sold Amount')}}</p>
                                                <h3 class="font-weight-bolder mb-0">{{ $stage->sells()->where('status','confirmed')->sum('amount') }}</h3>
                                            </div>
                                            <div class="col-6 py-1">
                                                <p class="card-text text-muted mb-0">{{__('Total Amount')}}</p>
                                                <h3 class="font-weight-bolder mb-0">{{ $stage->amount }}</h3>
                                            </div>
                                        </div>
                                        @if($stage->started_at && $stage->finished_at)
                                            <div class="row border-top text-center mx-0">
                                                <div class="col-6 border-right py-1">
                                                    <p class="card-text text-muted mb-0">{{__('Start Time')}}</p>
                                                    <h3 class="font-weight-bolder mb-0">{{ $stage->started_at ?? '-' }}</h3>
                                                </div>
                                                <div class="col-6 py-1">
                                                    <p class="card-text text-muted mb-0">{{__('End Time')}}</p>
                                                    <h3 class="font-weight-bolder mb-0">{{ $stage->finished_at ?? '-' }}</h3>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-danger w-100 p-2 text-center">
                                {{ __('There is no active stage!') }}
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-between mb-0">
                        <button class="btn btn-outline-secondary btn-prev" disabled>
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">{{__('Previous')}}</span>
                        </button>
                        <button class="btn btn-primary btn-next" id="stage-next">
                            <span class="align-middle d-sm-inline-block d-none">{{__('Next')}}</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </div>
                <div id="purchase-method" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">{{ __('Payment Method') }}</h5>
                        <small>{{ __('Choose a method for payment') }}</small>
                    </div>
                    <div class="row">
                        @forelse($methods as $method)
                            <div class="card shadow-none bg-transparent border-secondary col-12">
                                <div class="card-header">
                                    <h4 class="card-title text-primary">{{$method->name}}</h4>
                                    <p class="card-text">{{$method->description}}</p>
                                </div>
                                <div class="card-body row">
                                    @forelse($method->cryptoGateways as $cryptogateway)
                                        <div class="col-1">
                                            <div class="custom-control custom-radio mt-3">
                                                <input type="radio" id="gateway{{$cryptogateway->id}}" name="gateway" class="custom-control-input" value="{{$cryptogateway->id}}" @if($loop->first) checked @endif  required>
                                                <label class="custom-control-label" for="gateway{{$cryptogateway->id}}"></label>
                                            </div>
                                        </div>
                                        <div class="card bg-secondary text-white col-11">
                                            <div class="card-body">
                                                <div class="col-10">
                                                    <h4 class="card-title text-white">{{$cryptogateway->name}}</h4>
                                                    <p class="card-text">{{$cryptogateway->description}}</p>
                                                </div>
                                                <div class="col-2">
                                                    @if($cryptogateway->image)
                                                        <img src="{{ $cryptogateway->image }}" alt="{{ $cryptogateway->name }}"/>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-danger w-100 p-2 text-center">
                                            {{ __('There is no active gateway!') }}
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-danger w-100 p-2 text-center">
                                {{ __('There is no active payment method!') }}
                            </div>
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">{{__('Previous')}}</span>
                        </button>
                        <button class="btn btn-primary btn-next" id="method-next">
                            <span class="align-middle d-sm-inline-block d-none">{{__('Next')}}</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </div>
                <div id="purchase-external-wallet" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">{{ __('External Wallet') }}</h5>
                        <small>{{ __('Choose the external wallet to transfer') }}</small>
                    </div>
                    <div>
                        @forelse($user->enabledExternalWallets() as $externalwallet)
                            <div id="external_type_{{$externalwallet->type}}" class="external_wallets row">
                                <div class="col-1">
                                    <div class="custom-control custom-radio mt-3">
                                        <input type="radio" id="external_wallet{{$externalwallet->id}}" name="external_wallet" class="custom-control-input" value="{{$externalwallet->id}}" @if($loop->first) checked @endif required>
                                        <label class="custom-control-label" for="external_wallet{{$externalwallet->id}}"></label>
                                    </div>
                                </div>
                                <div class="card bg-secondary text-white col-11">
                                    <div class="card-body row">
                                        <div class="col-6">
                                            <h4 class="card-title text-white">{{$externalwallet->name}}</h4>
                                            <p class="card-text">{{$externalwallet->description}}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="card-text">{{$externalwallet->address}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-danger w-100 p-2 text-center external_alert">
                                {{ __('There is no enabled external wallet! Please add an external wallet.') }}
                            </div>
                        @empty
                            <div class="alert alert-danger w-100 p-2 text-center">
                                {{ __('There is no enabled external wallet! Please add an external wallet.') }}
                            </div>
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">{{__('Previous')}}</span>
                        </button>
                        <button class="btn btn-primary btn-next" id="external-next">
                            <span class="align-middle d-sm-inline-block d-none">{{__('Next')}}</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </div>
                <div id="purchase-amount" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">{{ __('Amount') }}</h5>
                        <small>{{ __('Determine the amount you will purchase') }}</small>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="min_buy">{{__('The minimum amount you can get')}}</label>
                                <input type="text" class="form-control" id="min_buy" readonly="readonly" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="max_buy">{{__('The maximum amount you can get')}}</label>
                                <input type="text" class="form-control" id="max_buy" readonly="readonly" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="bonus_info">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="min_for_bonus">{{__('Minimum buying limit for bonus')}}</label>
                                <input type="text" class="form-control" id="min_for_bonus" readonly="readonly" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="bonus_rate">{{__('Bonus Rate')}}</label>
                                <input type="text" class="form-control" id="bonus_rate" readonly="readonly" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">{{__('Current Price')}}</label>
                                <input type="text" class="form-control form-control-lg" id="price" readonly="readonly" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="market_info">{{__('Market Information')}}</label>
                                <input type="text" class="form-control form-control-lg" id="market_info" readonly="readonly" value="">
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{ route('user.purchase.prepare') }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="form_gateway" name="form_gateway" />
                        <input type="hidden" id="form_external_wallet" name="form_external_wallet" />
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="purchase_amount">{{__('Please type the amount you want to buy')}}</label>
                                <input type="number" class="form-control form-control-lg" id="purchase_amount" name="purchase_amount" step="1" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="method_value">{{__('You can type amount according to Payment Method')}}</label>
                                <input type="number" class="form-control form-control-lg" id="method_value" name="method_value" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">{{__('Previous')}}</span>
                        </button>
                        <button class="btn btn-success btn-next" id="submit-purchase" type="submit">
                            <span class="align-middle d-sm-inline-block d-none">{{__('Submit')}}</span>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @if($payments)
    <div class="row" id="dark-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('Pending Purchases')}}</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ __('You are viewing pending purchases. You can cancel while at this stage.') }}
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th>{{ __('Actions') }}</th>
                            <th>{{ __('Gateway') }}</th>
                            <th>{{ __('External Wallet') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Payable') }}</th>
                            <th>TX HASH</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Timestamp') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm text-dark dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item text-danger cancel_purchase" data-id="{{$payment->id}}">
                                                    <i data-feather="x-circle" class="mr-50"></i>
                                                    <span>{{__('Cancel')}}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="font-weight-bold">{{ \App\Models\CryptoGateway::find($payment->gateway_id)->name }}</span></td>
                                    <td>{{ \App\Models\ExternalWallet::find($payment->external_wallet_id)->name }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->price }}</td>
                                    <td>{{ $payment->payable }} {{ \App\Models\CryptoGateway::find($payment->gateway_id)->symbol }}</td>
                                    <td>{{ $payment->txhash }}</td>
                                    <td>
                                        @if($payment->status=="pending")
                                            <span class="badge badge-pill badge-light-warning mr-1">{{ __('Pending') }}</span>
                                        @elseif($payment->status=="confirmed")
                                            <span class="badge badge-pill badge-light-success mr-1">{{ __('Confirmed') }}</span>
                                        @elseif($payment->status=="canceled")
                                            <span class="badge badge-pill badge-light-danger mr-1">{{ __('Canceled') }}</span>
                                        @elseif($payment->status=="rejected")
                                            <span class="badge badge-pill badge-light-danger mr-1">{{ __('Rejected') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@section('page-scripts')
    <script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-wizard.js') }}"></script>
    <script>
        $('#bonus_info').hide();
        $('.external_wallets').hide();
        $('.external_alert').hide();

        $('#stage-next').click(function (e)
        {
            e.preventDefault();
            sessionStorage.stage = $('input[name=stage]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{route('user.purchase.stage')}}',
                data: {stage: sessionStorage.stage},
                dataType: 'json',
                success: function (response) {
                    $('#min_buy').val(response.min_buy);
                    $('#max_buy').val(response.max_buy);
                    $('#purchase_amount').attr('min',response.min_buy);
                    $('#purchase_amount').attr('max',response.max_buy);
                    $('#purchase_amount').val(response.min_buy);
                    $('#price').val(response.price);
                },
                error: function (response) {

                }
            });
            $.ajax({
                type: 'POST',
                url: '{{route('user.purchase.bonus')}}',
                data: {stage: sessionStorage.stage},
                dataType: 'json',
                success: function (response) {
                    if(response.status)
                    {
                        $('#bonus_info').show();
                        $('#min_for_bonus').val(response.min_for_bonus);
                        $('#bonus_rate').val(response.bonus_rate + ' %');
                    }
                },
                error: function (response) {

                }
            });
        });
        var current_val;
        $('#method-next').click(function (e)
        {
            e.preventDefault();
            sessionStorage.gateway = $('input[name=gateway]:checked').val();
            $('#form_gateway').val(sessionStorage.gateway);
            $.ajax({
                type: 'POST',
                url: '{{route('user.purchase.market')}}',
                data: {gateway: sessionStorage.gateway},
                dataType: 'json',
                success: function (response) {
                    $('#market_info').val('1 ' + response.symbol + ' = $ ' + response.value);
                    sessionStorage.decimal=response.decimal;
                    current_val = response.value;
                    $('#method_value').attr('step', 1/(Math.pow(10,response.decimal)))
                    $('.external_wallets').hide();
                    $('#external_type_'+response.symbol).show();
                    if($('.external_wallets:visible').length == 0)
                    {
                        $('.external_alert').first().show();
                    } else {
                        $('.external_alert').hide();
                    }
                    if (response.message) {
                        $(document).ready(function() {
                            swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                buttonsStyling: false
                            });
                        });
                    }
                },
                error: function (response) {
                }
            });
        });
        $('#external-next').click(function (e)
        {
            e.preventDefault();
            sessionStorage.external = $('input[name=external_wallet]:checked').val();
            $('#form_external_wallet').val(sessionStorage.external);
        });
        $('input[id=purchase_amount]').on('input keyup change paste',function() {
            var amount = $('input[id=purchase_amount]').val();
            var price = $('input[id=price]').val();
            $('input[id=method_value]').val(Number(amount*price/current_val).toFixed(sessionStorage.decimal));
        });
        $('input[id=method_value]').on('input keyup change paste',function() {
            var payment = $('input[id=method_value]').val();
            var price = $('input[id=price]').val();
            $('input[id=purchase_amount]').val(Number(payment*current_val/price).toFixed(0));
        });


    </script>
    <script>
        $('.cancel_purchase').click(async function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            const { value: password } = await swal.fire({
                title: 'You are canceling the purchase',
                input: 'password',
                icon: 'question',
                inputPlaceholder: 'Enter your password',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                confirmButtonText: 'Confirm',
                showCancelButton: true,
            }).then((willCancel) => {
                if (willCancel.isConfirmed) {
                    if (willCancel.value) {
                        $.ajax({
                            url: "{{route('user.purchase.cancel')}}",
                            type: "PUT",
                            data: {password: willCancel.value, id: id},
                            success:function(response){
                                if (response.success) {
                                    $(document).ready(function() {
                                        swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: response.success,
                                            showConfirmButton: false,
                                            timer: 1500,
                                            buttonsStyling: false
                                        });
                                    });
                                }
                                if (response.message) {
                                    $(document).ready(function() {
                                        swal.fire({
                                            position: 'top-end',
                                            icon: 'error',
                                            title: response.message,
                                            showConfirmButton: false,
                                            timer: 2000,
                                            buttonsStyling: false
                                        });
                                    });
                                }
                                window.setTimeout(function(){location.reload()},2000)
                            },
                            error: function(response) {
                                if (response.message) {
                                    $(document).ready(function() {
                                        swal.fire({
                                            position: 'top-end',
                                            icon: 'error',
                                            title: response.message,
                                            showConfirmButton: false,
                                            timer: 1500,
                                            buttonsStyling: false
                                        });
                                    });
                                }
                                window.setTimeout(function(){location.reload()},2000)
                            }
                        });
                    }
                }
            });
        });
    </script>
@endsection
