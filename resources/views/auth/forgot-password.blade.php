@extends('layouts.auth')
@section('title')
    {{ __('Forgot Password') }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/page-auth.css')}}">
@endsection

@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <a href="javascript:void(0);" class="brand-logo">
                <img src="{{ asset('assets/images/logo/logo.png') }}" style="height: 100px; width: 100px;">
            </a>

            <h2 class="brand-text text-primary text-center">{{ \App\Models\Setting::where('setting', 'title')->first()->value }}</h2>

            @if (session('status'))
                <div class="alert alert-success mt-2" role="alert">
                    <h4 class="alert-heading">Success</h4>
                    <div class="alert-body">
                        {{ session('status') }}
                    </div>
                </div>
            @else
                <p class="card-text mt-2">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="auth-forgot-password-form mt-2" action="{{ route('password.email') }}" method="POST">
                @csrf
                {!! RecaptchaV3::field('forgot') !!}
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" aria-describedby="email" tabindex="1" value="{{ old('email') }}" autofocus required/>
                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="2">{{ __('Email Password Reset Link') }}</button>
            </form>

            <p class="text-center mt-2">
                <a href="{{ route('login') }}"> <i data-feather="chevron-left"></i> {{ __('Login') }} </a>
            </p>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{asset('app-assets/js/scripts/pages/page-auth-forgot-password.js')}}"></script>
@endsection
