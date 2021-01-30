@extends('layouts.admin.master')
@section('title')
    {{__('Create New Stage')}}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice.css') }}">
@endsection
@section('header_title')
    {{__('Create New Stage')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-warning" href="{{ route('admin.stages.index') }}"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
@endsection
@section('content')

    <section class="invoice-edit-wrapper">
        @include('layouts.admin.errors')
        <form class="form" method="post" action="{{ route('admin.stages.store') }}">
            @csrf
            <div class="row invoice-edit">
                <div class="col-xl-9 col-md-8 col-12">
                    <div class="card invoice-preview-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Stage Name') }}*</label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Stage Name') }}" value="{{ old('name') }}" required/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="description">{{ __('Stage Description') }}</label>
                                        <input type="text" id="description" class="form-control" name="description" placeholder="{{ __('Stage Description') }}" value="{{ old('description') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="softcap">{{ __('Soft Cap') }}</label>
                                        <input type="number" id="softcap" class="form-control"  name="softcap" placeholder="{{ __('Soft Cap') }}" value="{{ old('softcap') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="hardcap">{{ __('Hard Cap') }}</label>
                                        <input type="number" id="hardcap" class="form-control" name="hardcap" placeholder="{{ __('Hard Cap') }}" value="{{ old('hardcap') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="min_buy">{{ __('Minimum Buy') }}</label>
                                        <input type="number" id=min_buy" class="form-control" name="min_buy" placeholder="{{ __('Minimum Buy') }}"  value="{{ old('min_buy') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="max_buy">{{ __('Maximum Buy') }}</label>
                                        <input type="number" id="max_buy" class="form-control" name="max_buy" placeholder="{{ __('Maximum Buy') }}"  value="{{ old('max_buy') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="starttime">{{ __('Start Time') }}</label>
                                        <input type="text" id="starttime" class="form-control flatpickr" name="started_at" placeholder="{{ __('Start Time') }}"  value="{{ old('started_at') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="endtime">{{ __('End Time') }}</label>
                                        <input type="text" id="endtime" class="form-control flatpickr" name="finished_at" placeholder="{{ __('End Time') }}"  value="{{ old('finished_at') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="d-flex justify-content-between mt-2">
                                        <label class="invoice-terms-title mb-0" for="bonus">{{__('Buying Bonus')}}</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="bonus" name="bonus_status" value="checked" @if(old('bonus_status')=='checked') checked @endif/>
                                            <label class="custom-control-label" for="bonus"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="min_bonus">{{ __('Minimum Buy for Bonus') }}</label>
                                        <input type="number" id="min_bonus" class="form-control" name="bonus_minimum" placeholder="{{ __('Minimum Buy for Bonus') }}"  value="{{ old('bonus_minimum') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="rate_bonus">{{ __('Bonus Rate (%)') }}</label>
                                        <input type="number" id="rate_bonus" class="form-control" name="bonus_rate" placeholder="{{ __('Bonus Rate (%)') }}"  value="{{ old('bonus_rate') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="price_type">{{ __('Price Type') }}* (Soon)</label>
                                <select class="form-control" name="price_type" id="price_type">
                                    <option @if(old('price_type')=="fixed") selected @endif value="fixed">{{__('Fixed')}}</option>
                                    <option @if(old('price_type')=="variable") selected @endif value="variable" disabled>{{__('Variable')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fixed_price">{{ __('Fixed Price') }}*</label>
                                <input type="number" min="0" step="0.0001" class="form-control" name="fixed_price" id="fixed_price" value="{{ old('fixed_price') }}" required/>
                            </div>
                            <div class="form-group">
                                <label for="amount">{{ __('Token Amount') }}*</label>
                                <input type="number" class="form-control" name="amount" id="amount" value="{{ old('amount') }}" required/>
                            </div>
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select class="form-control" name="status" id="status">
                                    <option @if(old('status')=='pending') selected @endif value="pending">{{__('Pending')}}</option>
                                    <option @if(old('status')=='running') selected @endif value="running">{{__('Running')}}</option>
                                    <option @if(old('status')=='done') selected @endif value="done">{{__('Done')}}</option>
                                    <option @if(old('status')=='canceled') selected @endif value="canceled">{{__('Canceled')}}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block my-75">
                                <i class="fa fa-save"></i>
                                {{__('Save')}}
                            </button>
                            <button type="reset" class="btn btn-warning btn-block mb-75">
                                <i class="fa fa-redo"></i>
                                {{__('Reset')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection
@section('page-scripts')
    <script src="{{ asset('app-assets/js/scripts/pages/app-invoice.js') }}"></script>
@endsection

