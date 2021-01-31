@extends('layouts.admin.master')
@section('title')
    {{__('Show User')}}: {{ $user->name }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-user.css')}}">
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
                                            <img class="img-fluid rounded" src="storage/{{ $user->profile_photo_path }}" height="104" width="104" alt="{{ $user->name }}" />
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
                                            <h5 class="mb-0">0</h5>
                                            <small>{{__('Balance')}}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="color-box bg-light-success">
                                            <i data-feather="trending-up" class="text-success"></i>
                                        </div>
                                        <div class="ml-1">
                                            <h5 class="mb-0">0</h5>
                                            <small>{{__('Referenced Users')}}</small>
                                        </div>
                                    </div>
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
                                    <div class="d-flex flex-wrap">
                                        <div class="user-info-title">
                                            <i data-feather="log-in" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">{{__('Last Login')}}</span>
                                        </div>
                                        <p class="card-text mb-0">{{ $user->getLastLogin() }}</p>
                                    </div>
                                    @if($user->isBanned())
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <i data-feather="slash" class="mr-1"></i>
                                                <span class="card-text user-info-title font-weight-bold mb-0">{{__('Banned At')}}</span>
                                            </div>
                                            <p class="card-text mb-0">{{ $user->banned_at }}</p>
                                        </div>
                                    @endif
                                    @if($user->isBanned())
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <i data-feather="slash" class="mr-1"></i>
                                                <span class="card-text user-info-title font-weight-bold mb-0">{{__('Ban Expires')}}</span>
                                            </div>
                                            <p class="card-text mb-0">
                                                @if($ban->isPermanent())
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
                            <a href="" class="btn btn-icon btn-info waves-effect waves-float waves-light ml-1" title="{{__('Send Telegram Message')}}"><i class="far fa-paper-plane"></i></a>
                        </div>
                        @if(!in_array('Super Admin',$user->getRoleNames()->all()))
                            <a class="btn btn-primary text-center btn-block" href="{{route('admin.users.edit',$user)}}"><i class="fas fa-user-edit"></i> {{ __('Edit') }}</a>
                            @if(!$user->email_verified_at)
                                <a class="btn btn-info text-center btn-block" href=""><i class="fas fa-user-check"></i>  {{ __('Verify User') }}</a>
                            @endif
                            @if(!in_array('Admin',$user->getRoleNames()->all()))
                                <a class="btn btn-secondary text-center btn-block" href=""><i class="fas fa-user-check"></i>  {{ __('Assign Admin') }}</a>
                                @if(!in_array('Editor',$user->getRoleNames()->all()))
                                    <a class="btn btn-secondary text-center btn-block" href=""><i class="fas fa-user-check"></i>  {{ __('Assign Editor') }}</a>
                                @else
                                    <a class="btn btn-light text-center btn-block" href=""><i class="fas fa-user-times"></i>  {{ __('Unassign Editor') }}</a>
                                @endif
                                @if(!in_array('Accountant',$user->getRoleNames()->all()))
                                    <a class="btn btn-secondary text-center btn-block" href=""><i class="fas fa-user-check"></i>  {{ __('Assign Accountant') }}</a>
                                @else
                                    <a class="btn btn-light text-center btn-block" href=""><i class="fas fa-user-times"></i>  {{ __('Unassign Accountant') }}</a>
                                @endif
                            @else
                                <a class="btn btn-light text-center btn-block" href=""><i class="fas fa-user-times"></i>  {{ __('Unassign Admin') }}</a>
                            @endif
                            @if($user->isBanned())
                                <a class="btn btn-info text-center btn-block" href=""><i class="fas fa-user"></i>  {{ __('Unban User') }}</a>
                            @else
                                <a class="btn btn-danger text-center btn-block" href=""><i class="fas fa-user-slash"></i>  {{ __('Ban User') }}</a>
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
                                <a class="nav-link active" id="wallets-tab-justified" data-toggle="tab" href="#wallets" role="tab" aria-controls="wallets" aria-selected="true">{{__('Wallets')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="external-wallets-tab-justified" data-toggle="tab" href="#external-wallets" role="tab" aria-controls="external-wallets" aria-selected="true">{{__('External Wallets')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="referrals-tab-justified" data-toggle="tab" href="#referrals" role="tab" aria-controls="referrals" aria-selected="false">{{__('Referrals')}}</a>
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
                                    @foreach($user->getExternalWallets as $wallet)
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
                                <p>
                                    Croissant jelly tootsie roll candy canes. Donut sugar plum jujubes sweet roll chocolate cake wafer. Tart
                                    caramels jujubes. Dragée tart oat cake. Fruitcake cheesecake danish. Danish topping candy jujubes. Candy
                                    canes candy canes lemon drops caramels tiramisu chocolate bar pie.
                                </p>
                                <p>
                                    Gummi bears tootsie roll cake wafer. Gummies powder apple pie bear claw. Caramels bear claw fruitcake
                                    topping lemon drops. Carrot cake macaroon ice cream liquorice donut soufflé. Gummi bears carrot cake
                                    toffee bonbon gingerbread lemon drops chocolate cake.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-scripts')
    <script src="{{asset('app-assets/js/scripts/pages/app-user-view.js')}}"></script>
@endsection
