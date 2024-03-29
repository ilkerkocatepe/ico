@extends('layouts.admin.master')
@section('title')
    {{__('Crypto Pays')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('Crypto Pays')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> {{ __('Dashboard') }}</a>
@endsection
@section('content')
    <section id="crypto_pays">
        <div class="row" id="table-hover-animation">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            {{ __('You see all of crypto pays') }}
                        </p>

                    </div>
                    <div class="table-responsive">
                        <table id="crypto_paysTable" class="invoice-list-table table table-hover table-hover-animation" data-page-length='10'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Stage')}}</th>
                                <th>{{__('User')}}</th>
                                <th>{{__('Gateway')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($crypto_pays as $pay)
                                <tr>
                                    <td>
                                        {{ $pay->id }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.stages.edit',$pay->sell->stage_id) }}">
                                            {{ \App\Models\Stage::find($pay->sell->stage_id)->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show',$pay->sell->user_id) }}">
                                            {{ \App\Models\User::find($pay->sell->user_id)->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.crypto-gateways.edit',$pay->gateway_id) }}">
                                            @if(\App\Models\CryptoGateway::find($pay->gateway_id)->icon)
                                                <i class="{{ \App\Models\CryptoGateway::find($pay->gateway_id)->icon }}"></i>
                                            @endif
                                            {{ \App\Models\CryptoGateway::find($pay->gateway_id)->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $pay->sell->amount }}
                                    </td>
                                    <td>
                                        {{ $pay->sell->price }}
                                    </td>
                                    <td>
                                        {{ $pay->sell->total }}
                                    </td>
                                    <td>
                                        @if($pay->sell->status=="pending")
                                            <span class="badge badge-pill badge-light-warning mr-1">{{ __('Pending') }}</span>
                                        @elseif($pay->sell->status=="confirmed")
                                            <span class="badge badge-pill badge-light-success mr-1">{{ __('Confirmed') }}</span>
                                        @elseif($pay->sell->status=="canceled")
                                            <span class="badge badge-pill badge-light-secondary mr-1">{{ __('Canceled') }}</span>
                                        @elseif($pay->sell->status=="rejected")
                                            <span class="badge badge-pill badge-light-danger mr-1">{{ __('Rejected') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $pay->sell->created_at }}
                                    </td>
                                    <td class="text-center">
                                        @if(\App\Models\CryptoGateway::find($pay->gateway_id)->payment_id == 1)
                                            <a href="{{ route('admin.crypto-pays.edit',$pay->id) }}">
                                                <span class="fa fa-eye" title="Show"></span>
                                            </a>
                                        @endif
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
@endsection
@section('page-scripts')
    <script>
        $(document).ready(function() {
            $('#crypto_paysTable').DataTable({
                order: [[8, 'desc']],
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
                        text: '{{__('Sells Page')}}',
                        className: 'btn btn-primary btn-add-record ml-2',
                        action: function (e, dt, button, config) {
                            window.location = '{{ route('admin.sells.index') }}';
                        }
                    }
                ],
            });
        } );
    </script>
@endsection
