@extends('layouts.user.master')
@section('title')
    {{ __('Referral Tree') }}
@endsection
@section('page-css')
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
