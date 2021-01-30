@extends('layouts.user.master')
@section('title')
    {{__('Referral Earnings')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('Referral Earnings')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i> {{ __('Dashboard') }}</a>
@endsection
@section('content')
    <section id="sells">
        <div class="row" id="table-hover-animation">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table id="earningsTable" class="invoice-list-table table table-hover table-hover-animation" data-page-length='10'>
                            <thead>
                            <tr>
                                <th>{{__('Referral')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Level')}}</th>
                                <th>{{__('Timestamp')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(auth()->user()->referral_earnings as $earning)
                                <tr>
                                    <td>
                                        {{ $earning->referral->name }}
                                    </td>
                                    <td>
                                        {{ $earning->amount }}
                                    </td>
                                    <td>
                                        {{ $earning->level }}
                                    </td>
                                    <td>
                                        {{ $earning->created_at }}
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
            $('#earningsTable').DataTable({
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
