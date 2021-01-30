@extends('layouts.admin.master')
@section('title')
    {{__('Edit')}} {{ $stage->name }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice-list.css') }}">
@endsection
@section('header_title')
    {{__('Edit')}} <span class="text-primary">{{ $stage->name }}</span>
@endsection
@section('top_right_button')
    <a class="btn btn-outline-warning" href="{{ route('admin.stages.index') }}"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
@endsection
@section('content')

    <section class="invoice-edit-wrapper">
        @include('layouts.admin.errors')
        <form class="form" method="post" action="{{ route('admin.stages.update',$stage) }}">
            @csrf
            @method('PUT')
            <div class="row invoice-edit">
            <div class="col-xl-9 col-md-8 col-12">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Stage Name') }}*</label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Stage Name') }}" value="{{$stage->name}}" required/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="description">{{ __('Stage Description') }}</label>
                                        <input type="text" id="description" class="form-control" name="description" placeholder="{{ __('Stage Description') }}"  value="{{$stage->description}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="softcap">{{ __('Soft Cap') }}</label>
                                        <input type="number" id="softcap" class="form-control"  name="softcap" placeholder="{{ __('Soft Cap') }}"  value="{{$stage->softcap}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="hardcap">{{ __('Hard Cap') }}</label>
                                        <input type="number" id="hardcap" class="form-control" name="hardcap" placeholder="{{ __('Hard Cap') }}"  value="{{$stage->hardcap}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="min_buy">{{ __('Minimum Buy') }}</label>
                                        <input type="number" id=min_buy" class="form-control" name="min_buy" placeholder="{{ __('Minimum Buy') }}"  value="{{$stage->min_buy}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="max_buy">{{ __('Maximum Buy') }}</label>
                                        <input type="number" id="max_buy" class="form-control" name="max_buy" placeholder="{{ __('Maximum Buy') }}"  value="{{$stage->max_buy}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="starttime">{{ __('Start Time') }}</label>
                                        <input type="text" id="starttime" class="form-control flatpickr" name="started_at" placeholder="{{ __('Start Time') }}" value="{{$stage->started_at}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="endtime">{{ __('End Time') }}</label>
                                        <input type="text" id="endtime" class="form-control flatpickr" name="finished_at" placeholder="{{ __('End Time') }}" value="{{$stage->finished_at}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="d-flex justify-content-between mt-2">
                                        <label class="invoice-terms-title mb-0" for="bonus">{{__('Buying Bonus')}}</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" @if($stage->bonus_status) checked @endif id="bonus" name="bonus_status" value="checked"/>
                                            <label class="custom-control-label" for="bonus"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="min_bonus">{{ __('Minimum Buy for Bonus') }}</label>
                                        <input type="number" id="min_bonus" class="form-control" name="bonus_minimum" placeholder="{{ __('Minimum Buy for Bonus') }}"  value="{{$stage->bonus_minimum}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="rate_bonus">{{ __('Bonus Rate (%)') }}</label>
                                        <input type="number" id="rate_bonus" class="form-control" name="bonus_rate" placeholder="{{ __('Bonus Rate (%)') }}"  value="{{$stage->bonus_rate}}"/>
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
                            <label for="soldamount">{{ __('Sold Amount') }}</label>
                            <input type="number" class="form-control" id="soldamount" value="{{ $stage->sells()->where('status','confirmed')->sum('amount') }}" disabled/>
                        </div>
                        <div class="form-group">
                            <label for="value_fixed">{{ __('Collected for Fixed Price') }}*</label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="value_fixed" value="{{ $stage->sells()->sum('amount')*$stage->fixed_price }}" disabled/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="price_type">{{ __('Price Type') }}* (Soon)</label>
                            <select class="form-control" name="price_type" id="price_type" disabled>
                                <option @if($stage->status=='fixed') selected @endif value="fixed">{{__('Fixed')}}</option>
                                <option @if($stage->status=='variable') selected @endif value="variable">{{__('Variable')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fixed_price">{{ __('Fixed Price') }}*</label>
                            <input type="number" class="form-control" name="fixed_price" id="fixed_price" value="{{ $stage->fixed_price }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="amount">{{ __('Token Amount') }}*</label>
                            <input type="number" class="form-control" name="amount" id="amount" value="{{ $stage->amount }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('Status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option @if($stage->status=='pending') selected @endif value="pending">{{__('Pending')}}</option>
                                <option @if($stage->status=='running') selected @endif value="running">{{__('Running')}}</option>
                                <option @if($stage->status=='done') selected @endif value="done">{{__('Done')}}</option>
                                <option @if($stage->status=='canceled') selected @endif value="canceled">{{__('Canceled')}}</option>
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
        </form>
                        <form id="deleteForm" action="{{ route('admin.stages.destroy',$stage) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button id="deleteStage" class="btn btn-danger btn-block mb-75" data-id="{{$stage->id}}">
                                <i class="fa fa-trash-alt"></i>
                                {{__('Delete')}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <div class="row" id="table-hover-animation">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Sells') }}</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{ __('You see sells which belongs to this stage') }}
                        </p>

                    </div>
                    <div class="table-responsive">
                        <table id="sellsTable" class="invoice-list-table table table-hover table-hover-animation">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('User')}}</th>
                                <th>{{__('Payment')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sells as $sell)
                                <tr onclick="window.location='{{ route('admin.crypto-pays.edit',$sell->id) }}'">
                                    <td>
                                        {{ $sell->id }}
                                    </td>
                                    <td>
                                        {{ \App\Models\User::find($sell->user_id)->name }}
                                    </td>
                                    <td>
                                        {{ \App\Models\PaymentMethod::find($sell->payment_id)->name }}
                                    </td>
                                    <td>
                                        {{ $sell->amount }}
                                    </td>
                                    <td>
                                        {{ $sell->price }}
                                    </td>
                                    <td>
                                        {{ $sell->total }}
                                    </td>
                                    <td>
                                        @if($sell->status=="pending")
                                        <span class="badge badge-pill badge-light-primary mr-1">{{ __('Pending') }}</span>
                                        @elseif($sell->status=="confirmed")
                                            <span class="badge badge-pill badge-light-success mr-1">{{ __('Confirmed') }}</span>
                                        @elseif($sell->status=="canceled")
                                            <span class="badge badge-pill badge-light-warning mr-1">{{ __('Canceled') }}</span>
                                        @elseif($sell->status=="rejected")
                                            <span class="badge badge-pill badge-light-danger mr-1">{{ __('Rejected') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $sell->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('page-scripts')
    <script src="{{ asset('app-assets/js/scripts/pages/app-invoice.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#sellsTable').DataTable({
                order: [[7, 'desc']],
                dom:
                    '<"row d-flex justify-content-between align-items-center m-1"' +
                    '<"col-lg-6 d-flex align-items-center"l<"dt-action-buttons text-xl-right text-lg-left text-lg-right text-left "B>>' +
                    '<"col-lg-6 d-flex align-items-center justify-content-lg-end flex-lg-nowrap flex-wrap pr-lg-1 p-0"f<"invoice_status ml-sm-2">>' +
                    '>t' +
                    '<"d-flex justify-content-between mx-2 row"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                buttons: [
                    {
                        text: '{{__('Sells Page')}}',
                        className: 'btn btn-primary btn-add-record ml-2',
                        action: function (e, dt, button, config) {
                            window.location = '{{ route('admin.sells.index') }}';
                        }
                    }
                ],
            });
        } );
    </script>

    <script>
        $('#deleteStage').click(function(event) {
            var form =  $('#deleteForm');
            event.preventDefault();
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                showCancelButton: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection

