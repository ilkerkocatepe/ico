@extends('layouts.user.master')
@section('title')
    {{ __('Invite People') }}
@endsection
@section('page-css')
@endsection
@section('header_title')
    {{ __('Invite People') }}
@endsection
@section('content')
    @php($user = \Illuminate\Support\Facades\Auth::user())
    <section id="invite-people">
        <div class="row">
            <img src="{{ asset('storage/assets/images/backend/referral.png') }}" style="width: 100%; height: auto;" alt="Referral Program" />
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header mx-auto">
                        <h4 class="card-title">{{ __('Your invitation link') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12 pr-sm-0">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="copy-referral-link" value="{{ url('/register').'/'.$user->refer_hash }}" readonly/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <button class="btn btn-outline-primary btn-block" id="btn-copy"><i class="fas fa-copy"></i> {{ __('Copy') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header mx-auto">
                        <h4 class="card-title">{{ __('Your invitation QR code') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-sm-6 col-12 pr-sm-0 mx-auto">
                                {!! QrCode::size(200)->style('round',0.9)->errorCorrection('H')->generate(url('/register').'/'.$user->refer_hash); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header mx-auto">
                        <h4 class="card-title">{{ __('Reference System Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>{{__('System Status')}}</td>
                                            <td>
                                                @if(true)
                                                    <span class="badge badge-light-success">{{__('Enabled')}}</span>
                                                @else
                                                    <span class="badge badge-light-warning">{{__('Disabled')}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Level Limit')}}</td>
                                            <td>5</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('storage/assets/images/backend/mlm.png') }}" style="width: 100%; height: auto;" alt="Reference System" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(count($user->children))
        <section id="referral-list">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('Referral List')}}</h4>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Level')}}</th>
                                <th>{{__('Register Date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('user.profile.children',['user' => $user])
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endif
@endsection
@section('page-scripts')
@endsection
