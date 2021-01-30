@extends('layouts.admin.master')
@section('title')
    {{__('Stages')}}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/charts/chart-apex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
@endsection
@section('header_title')
    {{__('Stages')}}
@endsection
@section('top_right_button')
    <a class="btn btn-outline-primary" href="{{ route('admin.stages.create') }}"><i class="fa fa-plus"></i> {{ __('New') }}</a>
@endsection
@section('content')

    <section id="stages">
        <div class="row">
            @foreach($stages as $stage)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $stage->name }}</h4>
                        <div class="ml-auto">
                            @if($stage->status == "running")
                            <a href="{{ route('admin.stages.index') }}">
                                <span class="far fa-pause-circle font-large-1" title="Pause"></span>
                            </a>
                            @endif
                            @if($stage->status != "running")
                            <a href="{{ route('admin.stages.index') }}">
                                <span class="far fa-play-circle font-large-1" title="Run"></span>
                            </a>
                            @endif
                            <a href="{{ route('admin.stages.edit',$stage->id) }}">
                                <span class="fas fa-cogs font-large-1" title="Settings"></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="stage-chart{{$stage->id}}" class="mx-auto"></div>
                        <div class="row mb-2">
                            <div class="col text-center">
                                @if($stage->status == 'running')
                                    <div class="badge badge-glow badge-success">{{__('Running')}}</div>
                                @elseif($stage->status == 'pending')
                                    <div class="badge badge-glow badge-warning">{{__('Pending')}}</div>
                                @elseif($stage->status == 'canceled')
                                    <div class="badge badge-glow badge-danger">{{__('Canceled')}}</div>
                                @elseif($stage->status == 'done')
                                    <div class="badge badge-glow badge-primary">{{__('Done')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row border-top text-center mx-0">
                            <div class="col-6 border-right py-1">
                                <p class="card-text text-muted mb-0">Sold</p>
                                <h3 class="font-weight-bolder mb-0">{{ $stage->sells()->where('status','confirmed')->sum('amount') }}</h3>
                            </div>
                            <div class="col-6 py-1">
                                <p class="card-text text-muted mb-0">Total</p>
                                <h3 class="font-weight-bolder mb-0">{{ $stage->amount }}</h3>
                            </div>
                        </div>
                        <div class="row border-top text-center mx-0">
                            <div class="col-6 border-right py-1">
                                <p class="card-text text-muted mb-0">Start Time</p>
                                <h3 class="font-weight-bolder mb-0">{{ $stage->started_at ?? '-' }}</h3>
                            </div>
                            <div class="col-6 py-1">
                                <p class="card-text text-muted mb-0">End Time</p>
                                <h3 class="font-weight-bolder mb-0">{{ $stage->finished_at ?? '-' }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
@endsection
@section('page-scripts')
    <script>
        var $strokeColor = '#ebe9f1';
        var $textHeadingColor = '#5e5873';

@foreach($stages as $stage)

        @if($stage->status == 'running')
            var $goalStrokeColor2 = '#51e5a8';
        @elseif($stage->status == 'pending')
            var $goalStrokeColor2 = '#FF8300';
        @elseif($stage->status == 'canceled')
            var $goalStrokeColor2 = '#FF3737';
        @elseif($stage->status == 'done')
            var $goalStrokeColor2 = '#37A7FF';
        @endif
        var $stageChart = document.querySelector('#stage-chart{{$stage->id}}');
        var stageChartOptions;
        var stageChart;
        stageChartOptions = {
            chart: {
                height: 200,
                type: 'radialBar',
                sparkline: {
                    enabled: true
                },
                dropShadow: {
                    enabled: true,
                    blur: 3,
                    left: 1,
                    top: 1,
                    opacity: 0.1
                }
            },
            colors: [$goalStrokeColor2],
            plotOptions: {
                radialBar: {
                    offsetY: -10,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%'
                    },
                    track: {
                        background: $strokeColor,
                        strokeWidth: '50%'
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            color: $textHeadingColor,
                            fontSize: '2.86rem',
                            fontWeight: '600'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: [window.colors.solid.success],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            series: [{{ number_format(($stage->sells()->where('status','confirmed')->sum('amount')*100 / $stage->amount), 1) }}],
            stroke: {
                lineCap: 'round'
            },
            grid: {
                padding: {
                    bottom: 30
                }
            }
        };
        stageChart = new ApexCharts($stageChart, stageChartOptions);
        stageChart.render();

@endforeach


    </script>
@endsection
