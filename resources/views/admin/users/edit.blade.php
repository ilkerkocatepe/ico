@extends('layouts.admin.master')
@section('title')
    {{__('Edit User')}}: {{ $user->name }}
@endsection
@section('page-css')

@endsection
@section('header_title')
    {{__('Edit User')}}: <span class="text-primary">{{ $user->name }}</span>
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> {{ __('User List') }}</a>
@endsection
@section('content')

@endsection
@section('page-scripts')

@endsection
