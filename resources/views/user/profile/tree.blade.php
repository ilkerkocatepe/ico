@extends('layouts.user.master')
@section('title')
    {{ __('Referral Tree') }}
@endsection
@section('page-css')
@endsection
@section('header_title')
    {{ __('Referral Tree') }}
@endsection
@section('content')
    <section id="invite-people">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if(count(auth()->user()->children))
                                @include('user.profile.tree.user',['user' => auth()->user()])
                            @else
                                <h3 class="mx-auto my-5">{{__('There is no one registered with your reference link!')}}</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-scripts')
@endsection
