@extends('layouts.auth')
@section('title')
    {{ __('Login') }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/page-auth.css')}}">
@endsection
@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <a href="{{ route('index') }}" class="brand-logo">
                <img src="{{ asset('storage/assets/front/images/logo.svg') }}" style="height: auto; width: 70%;">
            </a>

            <p class="card-text mt-2">Please sign-in to your account and start the adventure</p>
            <form class="auth-login-form" action="{{ route('login') }}" method="POST">
                @csrf
                {!! RecaptchaV3::field('login') !!}
                @if ($errors->any())
                    <div class="alert alert-danger p-1">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group @if($errors->any()) is-invalid @endif">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control @if($errors->any()) error @endif" id="email" name="email" placeholder="your@email.com" aria-describedby="login-email" tabindex="1" value="{{ old('email') }}" autofocus required/>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="login-password">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            <small>{{ __('Forgot your password?') }}</small>
                        </a>
                        @endif
                    </div>
                    <div class="input-group input-group-merge form-password-toggle @if($errors->any()) is-invalid @endif">
                        <input type="password" class="form-control form-control-merge @if($errors->any()) error @endif" id="password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" autocomplete="current-password" required/>
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="remember-me" name="remember" tabindex="3" />
                        <label class="custom-control-label" for="remember-me"> {{ __('Remember me') }} </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="4" value="login">{{ __('Login') }}</button>
            </form>
            @if (Route::has('register'))
            <p class="text-center mt-2">
                <span>New on our platform?</span>
                <a href="{{ route('register') }}">
                    <span>Create an account</span>
                </a>
            </p>
            @endif
            <div class="divider my-2">
                <hr>
            </div>

            @include('auth.socials')

        </div>
    </div>

@endsection

@section('page-js')
    <script src="{{asset('app-assets/js/scripts/pages/page-auth-login.js')}}"></script>
@endsection
