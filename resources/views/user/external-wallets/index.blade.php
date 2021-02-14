@extends('layouts.user.master')
@section('title')
    {{__('Your External Wallets')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('Your External Wallets')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('user.external-wallets.create') }}"><i class="fa fa-plus"></i> {{ __('Add New') }}</a>
@endsection
@section('content')
    @php($user = \Illuminate\Support\Facades\Auth::user())
    <section id="sells">
        <div class="row" id="table-hover-animation">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            {{ __('You see your external wallets.') }}
                        </p>
                        <p class="card-text text-warning">
                            {{ __('Note that you can only deposit and withdraw funds with these wallets.') }}
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table id="externalWalletsTable" class="invoice-list-table table table-hover" data-page-length='10'>
                            <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Address')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->externalWallets as $wallet)
                                <tr>
                                    <td>{{ $wallet->name }}</td>
                                    <td>{{ $wallet->description }}</td>
                                    <td>{{ $wallet->type }}</td>
                                    <td>{{ $wallet->address }}</td>
                                    <td>
                                        @if($wallet->status)
                                            <span class="badge badge-light-success">{{ __('Enabled') }}</span>
                                        @else
                                            <span class="badge badge-light-danger">{{ __('Disabled') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather='more-vertical'></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('user.external-wallets.edit',$wallet) }}" class="dropdown-item">
                                                    <i data-feather='edit-2'></i> {{ __('Edit') }}
                                                </a>
                                                @if(!count($wallet->crypto_pays))
                                                    <form id="deleteForm" method="post" action="{{ route('user.external-wallets.destroy',$wallet) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <a href="#" onclick="document.getElementById('deleteForm').submit();" class="dropdown-item text-danger">
                                                            <i data-feather='trash-2'></i> {{ __('Delete') }}
                                                        </a>
                                                    </form>
                                                @endif
                                                @if($wallet->status)
                                                    <form id="disableWallet" method="post" action="{{ route('user.external-wallets.disable',$wallet) }}">
                                                        @csrf
                                                        <a href="#" onclick="document.getElementById('disableWallet').submit();" class="dropdown-item text-warning">
                                                            <i data-feather='x-circle'></i> {{ __('Disable') }}
                                                        </a>
                                                    </form>
                                                @else
                                                    <form id="enableWallet" method="post" action="{{ route('user.external-wallets.enable',$wallet) }}">
                                                        @csrf
                                                        <a href="#" onclick="document.getElementById('enableWallet').submit();" class="dropdown-item text-success">
                                                            <i data-feather='check-circle'></i> {{ __('Enable') }}
                                                        </a>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
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
            $('#externalWalletsTable').DataTable({
                order: [[4, 'desc']],
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
