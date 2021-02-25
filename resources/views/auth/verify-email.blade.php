@extends('layouts.auth')
@section('title')
    {{ __('Verify Email') }}
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
                <img src="{{ asset('storage/assets/front/images/logo.svg') }}" style="height: auto; width: 70%;">
            </a>

            <div class="mb-2 text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success p-2">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <p class="text-warning">{{ __('Check your email firstly. If you didn\'t receive the email, we will gladly send you another.') }}</p>
            <div class="mt-2 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div>
                        <button type="submit" class="text-primary" tabindex="3">{{ __('Resend Verification Email') }}</button>
                    </div>
                </form>
                <br>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block" tabindex="4">{{ __('Logout') }}</button>
                </form>
            </div>

        </div>
    </div>

@endsection

@section('page-js')
    <script src="{{asset('app-assets/js/scripts/pages/page-auth-login.js')}}"></script>
@endsection
