@extends('layouts.admin.master')
@section('title')
    {{__('Show User')}}: {{ $user->name }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-user.css')}}">

    <style>

        .tree {
            padding: 20px;
            color: #212121;
            text-align: center;
        }
        .tree-widget {
            position: relative;
            padding: 20px 0;
            overflow-x: auto;
        }
        .tree-structure {
            font-size: 0;
            white-space: nowrap;
        }
        .tree-node {
            display: inline-block;
            margin: 0 4px;
            padding: 0 8px;
            border-radius: 12px;
            background: #ff4040;
            font-size: 12px;
            font-weight: bold;
            line-height: 24px;
            color: #fff;
            transition: all 0.2s ease-in-out 0s;
            cursor: pointer;
        }
        .tree-branch {
            position: relative;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .tree-branch:before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            display: block;
            height: 17px;
            margin-left: -1px;
            border-left: 2px solid #212121;
        }
        .tree-branch:after {
            content: '';
            position: absolute;
            top: 17px;
            left: 50%;
            display: block;
            width: 8px;
            height: 8px;
            margin: -5px 0 0 -4px;
            border-radius: 50%;
            background: #212121;
        }
        .tree-item {
            position: relative;
            display: inline-block;
            padding: 40px 0 0;
            vertical-align: top;
        }
        .tree-item:before {
            content: '';
            position: absolute;
            top: 15px;
            left: 50%;
            display: block;
            height: 25px;
            margin-left: -1px;
            border-left: 2px solid #212121;
        }
        .tree-item:after {
            content: '';
            position: absolute;
            top: 15px;
            display: block;
            border-top: 2px solid #212121;
        }
        .tree-item:first-child:after {
            left: 50%;
            width: 50%;
        }
        .tree-item:not(:first-child):not(:last-child):after {
            left: 0;
            width: 100%;
        }
        .tree-item:last-child:after {
            right: 50%;
            width: 50%;
        }
        .tree-item:first-child:last-child:after {
            display: none;
        }
    </style>
@endsection
@section('header_title')
    {{__('Show User')}}: <span class="text-primary">{{ $user->name }}</span>
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> {{ __('User List') }}</a>
@endsection
@section('content')
    <section id="user-show" class="app-user-view">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-7">
                <div class="card user-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                <div class="user-avatar-section">
                                    <div class="d-flex justify-content-start">
                                        @if($user->profile_photo_path)
                                            <img class="img-fluid rounded" src="{{ asset('storage/'.$user->profile_photo_path) }}" height="104" width="104" alt="{{ $user->name }}" />
                                        @else
                                            <img class="img-fluid rounded" src="https://ui-avatars.com/api/?name={{ $user->name }}&color=7F9CF5&background=EBF4FF" height="104" width="104" alt="{{ $user->name }}" />
                                        @endif
                                        <div class="d-flex flex-column ml-1">
                                            <div class="user-info mb-1">
                                                <h4 class="mb-0">{{ $user->name }}</h4>
                                                <span class="card-text">{{ $user->email }}</span>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center user-total-numbers">
                                    <div class="d-flex align-items-center mr-2">
                                        <div class="color-box bg-light-primary">
                                            <i data-feather="dollar-sign" class="text-primary"></i>
                                        </div>
                                        <div class="ml-1">
                                            <h5 class="mb-0">{{ $user->balance() }}</h5>
                                            <small>{{__('Balance')}}</small>
                                        </div>
                                    </div>
{{--                                    <div class="d-flex align-items-center">--}}
{{--                                        <div class="color-box bg-light-success">--}}
{{--                                            <i data-feather="trending-up" class="text-success"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="ml-1">--}}
{{--                                            <h5 class="mb-0">0</h5>--}}
{{--                                            <small>{{__('Referenced Users')}}</small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                <div class="user-info-wrapper">
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="check" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">{{__('Status')}}</span>
                                        </div>
                                        <p class="card-text mb-0">{{ $user->status() }}</p>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="user-info-title">
                                            <i data-feather="user" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Telegram</span>
                                        </div>
                                        <p class="card-text mb-0">{{ $user->telegram }}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="star" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">{{__('Roles')}}</span>
                                        </div>
                                        <p class="card-text mb-0">{{ implode(", ", $user->getRoleNames()->all()) }}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="flag" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">{{__('Country')}}</span>
                                        </div>
                                        <p class="card-text mb-0">{{ $user->country }}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="users" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">{{__('Referral')}}</span>
                                        </div>
                                        @if(\App\Models\User::find($user->referral))
                                            <a class="card-text mb-0" href="{{route('admin.users.show',\App\Models\User::find($user->referral))}}">{{ \App\Models\User::find($user->referral)->name }}</a>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="phone" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">{{__('Mobile')}}</span>
                                        </div>
                                        <p class="card-text mb-0">{{ $user->mobile }}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="user-plus" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">{{__('Register')}}</span>
                                        </div>
                                        <p class="card-text mb-0">{{ $user->created_at }}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="log-in" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">{{__('Last Login')}}</span>
                                        </div>
                                        <p class="card-text mb-0">{{ $user->actions->where('log_name','login')->last()->created_at ?? '' }}</p>
                                    </div>
                                    @if($user->isBanned())
                                        <div class="d-flex flex-wrap my-50">
                                            <div class="user-info-title">
                                                <i data-feather="slash" class="mr-1"></i>
                                                <span class="card-text user-info-title font-weight-bold mb-0">{{__('Banned At')}}</span>
                                            </div>
                                            <p class="card-text mb-0">{{ $user->banned_at }}</p>
                                        </div>
                                    @endif
                                    @if($user->isBanned())
                                        <div class="d-flex flex-wrap my-50">
                                            <div class="user-info-title">
                                                <i data-feather="slash" class="mr-1"></i>
                                                <span class="card-text user-info-title font-weight-bold mb-0">{{__('Ban Expires')}}</span>
                                            </div>
                                            <p class="card-text mb-0">
                                                @if($user->ban()->isPermanent())
                                                    {{ __('Permanent') }}
                                                @else
                                                    {{ $user->bans()->lastest()->first()->expired_at }}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="card plan-card border-primary">
                    <div class="card-header d-flex justify-content-between align-items-center pt-75 pb-1">
                        <h5 class="mb-0">{{ __('Actions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-1">
                            <a href="" class="btn btn-icon btn-info waves-effect waves-float waves-light ml-1" title="{{__('Send E-mail')}}"><i class="far fa-envelope"></i></a>
                        </div>
                        @if(!in_array('Super Admin',$user->getRoleNames()->all()))
                            <a class="btn btn-primary text-center btn-block" href="{{route('admin.users.edit',$user)}}"><i class="fas fa-user-edit"></i> {{ __('Edit') }}</a>
                            @if(!$user->email_verified_at)
                                <a class="btn btn-info text-center btn-block" href="{{ route('admin.verify', $user) }}"><i class="fas fa-user-check"></i>  {{ __('Verify User') }}</a>
                            @endif
                            @if(!in_array('Admin',$user->getRoleNames()->all()))
                                <a class="btn btn-secondary text-center btn-block" href="{{ route('admin.assign', [$user, 'Admin']) }}"><i class="fas fa-user-check"></i>  {{ __('Assign Admin') }}</a>
                                @if(!in_array('Editor',$user->getRoleNames()->all()))
                                    <a class="btn btn-secondary text-center btn-block" href="{{ route('admin.assign',[$user, 'Editor']) }}"><i class="fas fa-user-check"></i>  {{ __('Assign Editor') }}</a>
                                @else
                                    <a class="btn btn-light text-center btn-block" href="{{ route('admin.unassign',[$user, 'Editor']) }}"><i class="fas fa-user-times"></i>  {{ __('Unassign Editor') }}</a>
                                @endif
                                @if(!in_array('Accountant',$user->getRoleNames()->all()))
                                    <a class="btn btn-secondary text-center btn-block" href="{{ route('admin.assign',[$user, 'Accountant']) }}"><i class="fas fa-user-check"></i>  {{ __('Assign Accountant') }}</a>
                                @else
                                    <a class="btn btn-light text-center btn-block" href="{{ route('admin.unassign',[$user, 'Accountant']) }}"><i class="fas fa-user-times"></i>  {{ __('Unassign Accountant') }}</a>
                                @endif
                            @else
                                <a class="btn btn-light text-center btn-block" href="{{ route('admin.unassign', [$user, 'Admin']) }}"><i class="fas fa-user-times"></i>  {{ __('Unassign Admin') }}</a>
                            @endif
                            @if($user->isBanned())
                                <a class="btn btn-info text-center btn-block" href="{{ route('admin.unban', $user) }}"><i class="fas fa-user"></i>  {{ __('Unban User') }}</a>
                            @else
                                <a class="btn btn-danger text-center btn-block" href="{{ route('admin.ban', $user) }}"><i class="fas fa-user-slash"></i>  {{ __('Ban User') }}</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-justified" id="user-show-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="wallets-tab-justified" data-toggle="tab" href="#wallets" role="tab" aria-controls="wallets" aria-selected="true">{{__('User Wallets')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="external-wallets-tab-justified" data-toggle="tab" href="#external-wallets" role="tab" aria-controls="external-wallets" aria-selected="true">{{__('External Wallets')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="referrals-tab-justified" data-toggle="tab" href="#referrals" role="tab" aria-controls="referrals" aria-selected="false">{{__('Referrals')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="referral-earnings-tab-justified" data-toggle="tab" href="#referral-earnings" role="tab" aria-controls="referral-earnings" aria-selected="false">{{__('Ref. Earnings')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="activity-tab-justified" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">{{__('Activity')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="wallets" role="tabpanel" aria-labelledby="wallets-tab-justified">
                                <table class="table table-hover-animation">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Address') }}</th>
                                            <th>{{ __('Balance') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->getWallets as $wallet)
                                        <tr>
                                            <td>{{$wallet->id}}</td>
                                            <td>{{$wallet->type}}</td>
                                            <td>{{$wallet->address}}</td>
                                            <td>{{$wallet->balance}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="external-wallets" role="tabpanel" aria-labelledby="external-wallets-tab-justified">
                                <table class="table table-hover-animation">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Address') }}</th>
                                        <th>{{ __('Status') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->externalWallets as $wallet)
                                        <tr>
                                            <td>{{$wallet->id}}</td>
                                            <td>{{$wallet->name}}</td>
                                            <td>{{$wallet->type}}</td>
                                            <td>{{$wallet->address}}</td>
                                            <td>
                                                @if($wallet->status)
                                                    <span class="badge badge-pill badge-light-success">{{__('Active')}}</span>
                                                @else
                                                    <span class="badge badge-pill badge-light-warning">{{__('Inactive')}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="referrals" role="tabpanel" aria-labelledby="referrals-tab-justified">
                                @if(count($user->children))
                                    @include('user.profile.tree.user',['user' => $user])
                                @else
                                    <h3 class="mx-auto my-5 text-center">{{__('There is no one registered with the user\'s reference link!')}}</h3>
                                @endif
                            </div>
                            <div class="tab-pane" id="referral-earnings" role="tabpanel" aria-labelledby="referral-earnings-tab-justified">
                                <table class="table table-hover-animation">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Referral') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Level') }}</th>
                                        <th>{{ __('Timestamp') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->referral_earnings as $earning)
                                        <tr>
                                            <td>{{$earning->referral->name}}</td>
                                            <td>{{$earning->amount}}</td>
                                            <td>{{$earning->level}}</td>
                                            <td>{{$earning->created_at->diffForHumans()}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="activity" role="tabpanel" aria-labelledby="activity-tab-justified">
                                <div class="row" id="table-hover-animation">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="table-responsive">
                                                <table id="activityTable" class="invoice-list-table table table-hover table-hover-animation" data-page-length='10'>
                                                    <thead>
                                                    <tr>
                                                        <th>{{__('Description')}}</th>
                                                        <th>{{__('Details')}}</th>
                                                        <th>{{__('Timestamp')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($user->activity as $activity)
                                                        <tr>
                                                            <td>{{ $activity->description }}</td>
                                                            <td>
                                                                @if($activity->log_name == 'login')
                                                                    <span class="badge badge-light-success text-capitalize">{{ $activity->getExtraProperty('interface') }}</span>
                                                                    <span class="badge badge-light-secondary text-capitalize">{{ $activity->getExtraProperty('IP') }}</span>
                                                                    <span class="badge badge-light-info text-capitalize">{{ $activity->getExtraProperty('browser') }}</span>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>{{ $activity->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-scripts')
    <script>
        $(document).ready(function() {
            $('#activityTable').DataTable({
                order: [[2, 'desc']],
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
