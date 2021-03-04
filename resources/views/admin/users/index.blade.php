@extends('layouts.admin.master')
@section('title')
    {{__('Users')}}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('Users')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> {{ __('Dashboard') }}</a>
@endsection
@section('content')
    <section id="sells">
        <div class="row" id="table-hover-animation">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            {{ __('You see registered users.') }}
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table id="usersTable" class="invoice-list-table table table-hover" data-page-length='10'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('User')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Role')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex justify-content-left align-items-center">
                                            <div class="avatar-wrapper">
                                                <div class="avatar mr-1">
                                                    @if($user->profile_photo_path)
                                                    <img class="round" src="{{ asset('storage/'.$user->profile_photo_path) }}" style="height: 32px; width: 32px;" alt="{{ $user->name }}">
                                                    @else
                                                    <img class="round" src="https://ui-avatars.com/api/?name={{$user->name}}&color=7F9CF5&background=EBF4FF" style="height: 32px; width: 32px;" alt="{{ $user->name }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="{{ route('admin.users.show',$user->id) }}" class="user_name text-truncate">
                                                    <span class="font-weight-bold">{{ $user->name }}</span>
                                                </a>
                                            </div>
                                        </div>

                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->getRoleNames()->first() }}</td>
                                    <td>
                                        @if($user->status()=='Active')
                                            <span class="badge badge-pill badge-light-success">{{ __('Active') }}</span>
                                        @elseif($user->status()=='Not Verified')
                                            <span class="badge badge-light-warning">{{ __('Not Verified') }}</span>
                                        @elseif($user->status()=='Banned')
                                            <span class="badge badge-light-danger">{{ __('Banned') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i class="fas fa-stream"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-96px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a href="{{ route('admin.users.show',$user->id) }}" class="dropdown-item">
                                                    <i class="fas fa-user-circle"></i> {{ __('Show') }}
                                                </a>
                                                <a href="{{ route('admin.users.edit',$user->id) }}" class="dropdown-item">
                                                    <i class="fas fa-user-edit"></i> {{ __('Edit') }}
                                                </a>
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
            $('#usersTable').DataTable({
                order: [[0, 'desc']],
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
