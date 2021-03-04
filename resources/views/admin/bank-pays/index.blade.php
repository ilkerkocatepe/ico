@extends('layouts.admin.master')
@section('title')
    {{__('Bank Pays')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('Bank Pays')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('admin.bank-pays.create') }}"><i class="fa fa-plus"></i> {{ __('Add') }}</a>
@endsection
@section('content')
    <section id="bankpays">
        <div class="row" id="table-hover-animation">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            {{ __('You see all of bank pays') }}
                        </p>

                    </div>
                    <div class="table-responsive">
                        <table id="bankpaysTable" class="invoice-list-table table table-hover table-hover-animation" data-page-length='10'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Stage')}}</th>
                                <th>{{__('User')}}</th>
                                <th>{{__('Gateway')}}</th>
                                <th>{{__('Deposit Amount')}}</th>
                                <th>{{__('Rate')}}</th>
                                <th>{{__('Value')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bank_pays as $bank_pay)
                                <tr>
                                    <td>
                                        {{ $bank_pay->id }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.stages.edit',$bank_pay->sell->stage_id) }}">
                                            {{ \App\Models\Stage::find($bank_pay->sell->stage_id)->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.edit',$bank_pay->sell->user_id) }}">
                                            {{ \App\Models\User::find($bank_pay->sell->user_id)->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.crypto-gateways.edit',$bank_pay->bank_gateway_id) }}">
                                            {{ \App\Models\BankGateway::find($bank_pay->bank_gateway_id)->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $bank_pay->deposit_amount }}
                                    </td>
                                    <td>
                                        {{ $bank_pay->rate }}
                                    </td>
                                    <td>
                                        {{ $bank_pay->value }}
                                    </td>
                                    <td>
                                        @if($bank_pay->sell->status=="pending")
                                            <span class="badge badge-pill badge-light-warning mr-1">{{ __('Pending') }}</span>
                                        @elseif($bank_pay->sell->status=="confirmed")
                                            <span class="badge badge-pill badge-light-success mr-1">{{ __('Confirmed') }}</span>
                                        @elseif($bank_pay->sell->status=="canceled")
                                            <span class="badge badge-pill badge-light-secondary mr-1">{{ __('Canceled') }}</span>
                                        @elseif($bank_pay->sell->status=="rejected")
                                            <span class="badge badge-pill badge-light-danger mr-1">{{ __('Rejected') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $bank_pay->sell->created_at }}
                                    </td>
                                    <td class="text-center">
                                            <a href="{{ route('admin.bank-pays.edit',$bank_pay->id) }}">
                                                <span class="fa fa-eye" title="Show"></span>
                                            </a>
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
            $('#bankpaysTable').DataTable({
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
