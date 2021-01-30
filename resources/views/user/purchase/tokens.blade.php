@extends('layouts.user.master')
@section('title')
    {{__('My Tokens')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('My Tokens')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i> {{ __('Dashboard') }}</a>
@endsection
@section('content')
    @php($payments = auth()->user()->payments()->get())
    <section id="my-tokens">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card earnings-card border-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title mb-1">{{__('Your Current Assets')}}</h3>
                                <div class="font-small-2"></div>
                                <h2 class="my-1 text-right font-large-4"><span class="text-primary">{{ auth()->user()->balance() }}</span> {{ $tokenSymbol }}</h2>
                                <p class="card-text text-muted font-small-2 text-right">
                                    <span>{{ __('You got') }}</span>
                                    <span class="font-weight-bolder">68</span> {{-- TODO:Bonus --}}
                                    <span> {{ __('Bonus') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card earnings-card border-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title mb-1 text-right">{{ __('Estimated Value') }}</h3>
                                <div class="font-small-2"></div>
                                <h2 class="mb-1 font-large-4">$ <span class="text-info">{{ auth()->user()->balance() * \App\Models\Stage::activePrice() }}</span></h2>
                                <p class="card-text text-muted font-small-2">
                                    <span class="font-weight-bolder"><span>{{ __('Current Token Value') }}</span> $ {{ \App\Models\Stage::activePrice() }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($payments)
    <section id="purchases">
        <div class="row" id="table-hover-animation">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table id="purchasesTable" class="invoice-list-table table table-hover table-hover-animation" data-page-length='10'>
                            <thead>
                            <tr>
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
                                            <span class="badge badge-pill badge-light-secondary mr-1">{{ __('Canceled') }}</span>
                                        @elseif($payment->status=="rejected")
                                            <span class="badge badge-pill badge-light-danger mr-1">{{ __('Rejected') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $payment->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection
@section('page-scripts')

    <script>
        $(document).ready(function() {
            $('#purchasesTable').DataTable({
                order: [[7, 'desc']],
                dom:
                    '<"row d-flex justify-content-between align-items-center m-1"' +
                    '<"col-lg-6 d-flex align-items-center"l<"dt-action-buttons text-xl-right text-lg-left text-lg-right text-left "B>>' +
                    '<"col-lg-6 d-flex align-items-center justify-content-lg-end flex-lg-nowrap flex-wrap pr-lg-1 p-0"f<"invoice_status ml-sm-2">>' +
                    '>t' +
                    '<"d-flex justify-content-between mx-2 row"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                buttons: [
                    {
                        text: '{{__('Purchase')}}',
                        className: 'btn btn-primary btn-add-record ml-2',
                        action: function (e, dt, button, config) {
                            window.location = '{{ route('user.purchase.index') }}';
                        }
                    }
                ],
            });
        } );
    </script>
@endsection
