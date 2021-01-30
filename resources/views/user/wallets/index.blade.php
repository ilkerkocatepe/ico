@extends('layouts.user.master')
@section('title')
    {{__('wallets.Your Wallets')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('wallets.Your Wallets')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i> {{ __('Dashboard') }}</a>
@endsection
@section('content')
    @php($user = \Illuminate\Support\Facades\Auth::user())
    <section id="sells">
        <div class="row" id="table-hover-animation">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            {{ __('wallets.You see your internal wallets.') }}
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table id="walletsTable" class="invoice-list-table table table-hover table-hover-animation" data-page-length='10'>
                            <thead>
                            <tr>
                                <th>{{__('wallets.Type')}}</th>
                                <th>{{__('wallets.Address')}}</th>
                                <th>{{__('wallets.Balance')}}</th>
                                <th>{{__('wallets.Created')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->getWallets as $wallet)
                                <tr>
                                    <td>
                                        {{ $wallet->type }}
                                    </td>
                                    <td>
                                        {{ $wallet->address }}
                                    </td>
                                    <td>
                                        {{ $wallet->balance }}
                                    </td>
                                    <td>
                                        {{ $wallet->created_at }}
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
            $('#walletsTable').DataTable({
                order: [[3, 'desc']],
                dom:
                    '<"row d-flex justify-content-between align-items-center m-1"' +
                    '<"col-lg-6 d-flex align-items-center"l<"dt-action-buttons text-xl-right text-lg-left text-lg-right text-left "B>>' +
                    '<"col-lg-6 d-flex align-items-center justify-content-lg-end flex-lg-nowrap flex-wrap pr-lg-1 p-0"f<"invoice_status ml-sm-2">>' +
                    '>t' +
                    '<"d-flex justify-content-between mx-2 row"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                buttons: [],
            });
        } );
    </script>
@endsection
