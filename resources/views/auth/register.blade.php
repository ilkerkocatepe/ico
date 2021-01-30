@extends('layouts.auth')
@section('title')
    {{ __('Register') }}
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
            <p class="card-text mb-2">Let's sign up!</p>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="auth-register-form mt-2" action="{{ route('register') }}" method="POST">
                @csrf
                {!! RecaptchaV3::field('register') !!}

                @if(isset($reference) && \App\Models\Setting::value('reference_system'))
                    @php($reference_name = \App\Models\User::where('refer_hash',$reference)->first()->name ?? null)
                        @if(isset($reference_name))
                            <input type="hidden" id="reference" name="reference" value="{{ $reference }}">
                            <div class="form-group">
                                <label for="reference_name" class="form-label">{{ __('Who invited you?') }}</label>
                                <a href="{{ route('register') }}">
                                    <small>{{ __("I don't want to be invited") }}</small>
                                </a>
                                <input type="text" class="form-control" id="reference_name" name="reference_name" aria-describedby="reference_name" value="{{ $reference_name }}" readonly />

                            </div>
                        @endif
                @endif

                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="john doe" aria-describedby="name" tabindex="1" value="{{ old('name') }}" autofocus required/>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="your@email.com" aria-describedby="email" tabindex="2" value="{{ old('email') }}" required/>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-group input-group-merge form-password-toggle">
                        <input type="password" class="form-control form-control-merge" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="register-password" tabindex="3" autocomplete="new-password" required/>
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <div class="input-group input-group-merge form-password-toggle">
                        <input type="password" class="form-control form-control-merge" id="password_confirmation" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password_confirmation" tabindex="3" autocomplete="new-password" required/>
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="privacy-policy" name="privacy-policy" tabindex="4" required>
                        <label class="custom-control-label" for="privacy-policy">
                            I agree to <a href="javascript:void(0);">Privacy Policy & Terms</a>
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="5" value="register">{{ __('Register') }}</button>
            </form>

            <p class="text-center mt-2">
                <span>{{ __('Already registered?') }}</span>
                <a href="{{ route('login') }}">
                    <span>{{ __('Login') }}</span>
                </a>
            </p>

            <div class="divider my-2">
                <hr>
            </div>

            @include('auth.socials')
        </div>
    </div>

@endsection

@section('page-js')
    <script src="{{asset('app-assets/js/scripts/pages/page-auth-register.js')}}"></script>
@endsection
