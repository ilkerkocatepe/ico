@extends('layouts.auth')
@section('title')
    {{ __('Reset Password') }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/page-auth.css')}}">
@endsection

@section('content')
    <div class="card mb-0">
        <div class="card-body p-2">
            <a href="javascript:void(0);" class="brand-logo">
                <img src="{{ asset('assets/images/logo/logo.png') }}" style="height: 100px; width: 100px;">
            </a>

            <h2 class="brand-text text-primary text-center">{{ \App\Models\Setting::where('setting', 'title')->first()->value }}</h2>
            <p class="card-text mb-2">Your new password must be different from previously used passwords</p>
            @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success mt-2" role="alert">
                    <h4 class="alert-heading">Success</h4>
                    <div class="alert-body">
                        {{ session('status') }}
                    </div>
                </div>
            @endif
            <form class="auth-reset-password-form mt-2" action="{{ route('password.update') }}" method="POST">
                @csrf
                {!! RecaptchaV3::field('resetpass') !!}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" aria-describedby="email" tabindex="1" value="{{ old('email', $request->email) }}" autofocus required/>
                </div>
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="password">{{ __('Password') }}</label>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <input type="password" class="form-control form-control-merge" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" tabindex="1" required autocomplete="new-password"/>
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <input type="password" class="form-control form-control-merge" id="password_confirmation" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password_confirmation" tabindex="2" required autocomplete="new-password"/>
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="3" value="resetpass">{{ __('Reset Password') }}</button>
            </form>

            <p class="text-center mt-2">
                <a href="{{ route('login') }}"> <i data-feather="chevron-left"></i> {{ __('Login') }} </a>
            </p>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{asset('app-assets/js/scripts/pages/page-auth-reset-password.js')}}"></script>
@endsection
