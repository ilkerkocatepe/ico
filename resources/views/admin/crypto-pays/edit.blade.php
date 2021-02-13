@extends('layouts.admin.master')
@section('title')
    {{__('Edit Crypto Pay')}} {{ $cryptoPay->id }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice-list.css') }}">
@endsection
@section('header_title')
    {{__('Edit Crypto Pay')}}: <span class="text-primary">{{ $cryptoPay->id }}</span>
    @if($cryptoPay->sells->status=="canceled")
        <span class="badge badge-glow badge-warning ml-1 p-1">{{__('Canceled')}}</span>
    @elseif($cryptoPay->sells->status=="rejected")
        <span class="badge badge-glow badge-danger ml-1 p-1">{{__('Rejected')}}</span>
    @elseif($cryptoPay->sells->status=="confirmed")
        <span class="badge badge-glow badge-success ml-1 p-1">{{__('Confirmed')}}</span>
    @else
        <span class="badge badge-glow badge-primary ml-1 p-1">{{__('Pending')}}</span>
    @endif
@endsection
@section('top_right_button')
    <a class="btn btn-outline-warning" href="{{ route('admin.crypto-pays.index') }}"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
@endsection
@section('content')

    <section class="invoice-edit-wrapper">
        @include('layouts.admin.errors')
        <form class="form" method="post" action="{{ route('admin.crypto-pays.update',$cryptoPay) }}">
            @csrf
            @method('PUT')
            <div class="row invoice-edit">
                <div class="col-xl-9 col-md-8 col-12">
                    <div class="card invoice-preview-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <i class="fa fa-box fa-2x mr-1 mt-1 text-info"></i> <a class="badge badge-pill badge-glow badge-info font-medium-3 mb-2 p-1" href="{{ route('admin.stages.edit',$cryptoPay->sells->stage_id) }}">{{ \App\Models\Stage::find($cryptoPay->sells->stage_id)->name }}</a>
                                </div>
                                <div class="col-md-6 col-12">
                                    <i class="fa fa-check-circle fa-2x mr-1 mt-1 text-info"></i> <a class="badge badge-pill badge-glow badge-light-info font-medium-3 mb-2 p-1" href="{{ route('admin.crypto-gateways.edit',$cryptoPay->gateway_id) }}">{{ \App\Models\CryptoGateway::find($cryptoPay->gateway_id)->name }}</a>
                                </div>
                                <div class="col-md-6 col-12">
                                    <i class="fa fa-user fa-2x mr-1 mt-1 text-primary"></i> <a class="badge badge-pill badge-glow badge-primary font-medium-3 mb-2 p-1" href="{{ route('admin.users.show',$cryptoPay->sells->user_id) }}">{{ \App\Models\User::find($cryptoPay->sells->user_id)->name }}</a>
                                </div>
                                <div class="col-md-6 col-12">
                                    <i class="fas fa-wallet fa-2x mr-1 mt-1 text-primary"></i> <a class="badge badge-pill badge-glow badge-light-primary font-medium-3 mb-2 p-1" href="{{ route('admin.external-wallets.edit',$cryptoPay->external_wallet_id) }}">{{ \App\Models\ExternalWallet::find($cryptoPay->external_wallet_id)->name }}</a>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('User Wallet') }}</span>
                                        </div>
                                        <input type="text" id="user_wallet" class="form-control" name="user_wallet" value="{{\App\Models\ExternalWallet::find($cryptoPay->external_wallet_id)->address}}" readonly/>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" id="copy_user_wallet">{{__('Copy')}}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="amount">{{ __('Amount') }}*</label>
                                        <input type="number" id=amount" class="form-control" name="amount" placeholder="{{ __('Amount') }}"  value="{{$cryptoPay->sells->amount}}" required/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <label for="price">{{ __('Price') }}*</label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.0001" class="form-control" id="price" name="price" placeholder="{{ __('Price') }}"  value="{{$cryptoPay->sells->price}}" required/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <label for="total">{{ __('Total') }}*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.0001" class="form-control" id="total" name="total" placeholder="{{ __('Total') }}" value="{{$cryptoPay->sells->total}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="total">{{ __('Payment Instrument Value') }}*</label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" class="form-control" id="current_value" name="current_value" placeholder="{{ __('Payment Instrument Value') }}" value="{{$cryptoPay->current_value}}" required/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="total">{{ __('Payable') }}*</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" step="0.0001" id="payable" class="form-control" name="payable" placeholder="{{ __('Payable') }}" value="{{round($cryptoPay->payable,\App\Models\CryptoGateway::find($cryptoPay->gateway_id)->confirm_decimal)}}" required/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ \App\Models\CryptoGateway::find($cryptoPay->gateway_id)->symbol }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('Tx Hash') }}*</span>
                                        </div>
                                        <input type="text" id="txhash" class="form-control" name="txhash" placeholder="{{ __('Tx Hash') }}" value="{{$cryptoPay->txhash}}" required/>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" id="copy_txhash">{{__('Copy')}}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="user_note">{{ __('User Note') }}</label>
                                        <textarea id="user_note" class="form-control" name="user_note" placeholder="{{ __('User Note') }}" >{{$cryptoPay->sells->user_note}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="admin_note">{{ __('Admin Note') }}</label>
                                        <textarea id="admin_note" class="form-control" name="admin_note" placeholder="{{ __('Admin Note') }}" >{{$cryptoPay->sells->admin_note}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
                <div class="col-xl-3 col-md-4 col-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-block my-75">
                                <i class="fa fa-save"></i>
                                {{__('Save')}}
                            </button>
                            <button type="reset" class="btn btn-outline-warning btn-block mb-75">
                                <i class="fa fa-redo"></i>
                                {{__('Reset')}}
                            </button>
                            @if($cryptoPay->sells->status=="pending")
                                <form id="rejectForm" action="{{ route('admin.crypto-pays.reject') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="rejectId" name="rejectId" value="{{ $cryptoPay->id }}">
                                    <input type="hidden" id="rejectNote" name="rejectNote">
                                    <button id="rejectPay" class="btn btn-danger btn-block mb-75" >
                                        <i class="fa fa-times"></i>
                                        {{__('Reject')}}
                                    </button>
                                </form>
                                <form id="confirmForm" action="{{ route('admin.crypto-pays.confirm') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="confirmId" name="confirmId" value="{{ $cryptoPay->id }}">
                                    <input type="hidden" id="confirmNote" name="confirmNote">
                                    <button id="confirmPay" class="btn btn-success btn-block mb-75" >
                                        <i class="fa fa-check"></i>
                                        {{__('Confirm')}}
                                    </button>
                                </form>
                            @elseif($cryptoPay->sells->status=="rejected")
                                <form id="confirmForm" action="{{ route('admin.crypto-pays.confirm') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="confirmId" name="confirmId" value="{{ $cryptoPay->id }}">
                                    <input type="hidden" id="confirmNote" name="confirmNote">
                                    <button id="confirmPay" class="btn btn-success btn-block mb-75" >
                                        <i class="fa fa-check"></i>
                                        {{__('Confirm')}}
                                    </button>
                                </form>
                            @elseif($cryptoPay->sells->status=="confirmed")
                                <form id="rejectForm" action="{{ route('admin.crypto-pays.reject') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="rejectId" name="rejectId" value="{{ $cryptoPay->id }}">
                                    <input type="hidden" id="rejectNote" name="rejectNote">
                                    <button id="rejectPay" class="btn btn-danger btn-block mb-75" >
                                        <i class="fa fa-times"></i>
                                        {{__('Reject')}}
                                    </button>
                                </form>
                            @elseif($cryptoPay->sells->status=="canceled")
                            @endif
                        </div>
                    </div>
                    @if($transaction!==null)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mx-auto">{{__('Transaction Information')}}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover-animation">
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ __('Tx Hash') }}
                                        </td>
                                        <td>
                                            @if($transaction['txhash']=='error')
                                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                                            @elseif($transaction['txhash']=='found')
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($transaction['txhash']!='error')
                                    <tr>
                                        <td>
                                            {{ __('Sender') }}
                                        </td>
                                        <td>
                                            @if($transaction['sender']!=\App\Models\ExternalWallet::find($cryptoPay->external_wallet_id)->address)
                                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                                            @else
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Receiver') }}
                                        </td>
                                        <td>
                                            @if($transaction['receiver']!='found')
                                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                                            @else
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Value') }}
                                        </td>
                                        <td>
                                            @if(isset($transaction['value']))
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                            @else
                                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Confirmations') }}
                                        </td>
                                        <td>
                                            @if($transaction['confirmations'])
                                                {{$transaction['confirmations']}}
                                            @else
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Time Stamp') }}
                                        </td>
                                        <td>
                                            @if($transaction['time'])
                                                {{date("Y-m-d H:i:s", $transaction['time'])}}
                                            @else
                                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <p class="text-center mt-1 italic">
                                {{ $transaction['powered'] }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
        </div>
        <div class="row">
            {{ var_dump($transaction) }}
        </div>
    </section>
@endsection
@section('page-scripts')
    <script src="{{ asset('app-assets/js/scripts/pages/app-invoice.js') }}"></script>
    <script>
        var userText = $("#user_wallet"),
            btnCopy = $("#copy_user_wallet");
            btnCopy.on("click", function() {
                userText.select(),
                document.execCommand("copy"),
                toastr.success("", "{{__('Copied to clipboard!')}}")
            });
        var userText2 = $("#txhash"),
            btnCopy2 = $("#copy_txhash");
            btnCopy2.on("click", function() {
                userText2.select(),
                document.execCommand("copy"),
                toastr.success("", "{{__('Copied to clipboard!')}}")
            });
        $('input[name=amount]').on('input keyup change paste',function() {
            var amount = $('input[name=amount]').val();
            var price = $('input[name=price]').val();
            var total = Number((amount * price).toFixed({{\App\Models\CryptoGateway::find($cryptoPay->gateway_id)->confirm_decimal}}));
            $('input[name=total]').val(total);
        });
        $('input[name=price]').on('input keyup change paste',function() {
            var amount = $('input[name=amount]').val();
            var price = $('input[name=price]').val();
            var total = Number((amount * price).toFixed({{\App\Models\CryptoGateway::find($cryptoPay->gateway_id)->confirm_decimal}}));
            $('input[name=total]').val(total);
        });
    </script>


    <script>
        $('#rejectPay').click(function(event) {
            var form =  $('#rejectForm');
            event.preventDefault();
            const { value: note } = swal.fire({
                title: 'Enter your note',
                icon: 'warning',
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Reject!",
                showCancelButton: true,
                input: 'text',
                inputPlaceholder: 'Enter your note if you want'
            }).then((willReject) => {
                    if (willReject.isConfirmed) {
                        if (willReject.value) {
                            $('#rejectNote').val(willReject.value)
                        }
                        form.submit()
                    }
                });
        });
        $('#confirmPay').click(function(event) {
            var form =  $('#confirmForm');
            event.preventDefault();
            const { value: note } = swal.fire({
                title: 'Enter your note',
                icon: 'warning',
                confirmButtonClass: "btn-success",
                confirmButtonText: "Confirm!",
                showCancelButton: true,
                input: 'text',
                inputPlaceholder: 'Enter your note if you want'
            }).then((willReject) => {
                    if (willReject.isConfirmed) {
                        if (willReject.value) {
                            $('#confirmNote').val(willReject.value)
                        }
                        form.submit()
                    }
                });
        });
    </script>
@endsection
