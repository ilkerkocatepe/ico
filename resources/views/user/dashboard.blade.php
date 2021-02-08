@extends('layouts.user.master')
@section('title')
    {{ __('Dashboard') }}
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/charts/chart-apex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
@endsection
@section('content')
    @php($user = \Illuminate\Support\Facades\Auth::user())

    <section id="dashboard-ecommerce">
        <div class="row match-height">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card card-congratulations">
                    <div class="card-body text-center">
                        <img src="{{asset('app-assets/images/elements/decore-left.png')}}" class="congratulations-img-left" />
                        <img src="{{asset('app-assets/images/elements/decore-right.png')}}" class="congratulations-img-right" />
                        <div class="avatar avatar-xl bg-primary shadow">
                            <div class="avatar-content">
                                <i data-feather="star" class="font-large-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-1 text-white">{{ __('user-dash.Welcome') }} {{$user->name}},</h1>
                            <p class="card-text m-auto w-75">
                                {{ \App\Models\Setting::value('welcome_message') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="card card-statistics">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('user-dash.Balance') }}</h4>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 mr-25 mb-0"></p>
                        </div>
                    </div>
                    <div class="card-body statistics-body">
                        <div class="row">
                            <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-sm-0">
                                <div class="media">
                                    <div class="avatar bg-light-primary mr-2">
                                        <div class="avatar-content">
                                            <i class="fas fa-coins avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">
                                            {{ $user->balance() }}
                                        </h4>
                                        <p class="card-text font-small-3 mb-0">{{ __('user-dash.Your Tokens') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 col-12">
                                <div class="media">
                                    <div class="avatar bg-light-success mr-2">
                                        <div class="avatar-content">
                                            <i class="fas fa-dollar-sign avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">{{ $user->wallet->balance * \App\Models\Stage::activePrice() }}</h4>
                                        <p class="card-text font-small-3 mb-0">{{ __('user-dash.Estimated Value') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row match-height">

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h4 class="card-title">{{ __('user-dash.Running Stage')}}: <span class="badge badge-pill badge-light-success">{{ \App\Models\Stage::activeStage()->name }}</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(\App\Models\Stage::activeStage()->finished_at)
                                <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                        <h1 class="font-large-2 font-weight-bolder mt-2 mb-0">163</h1>
                                        <p class="card-text">days left</p>
                                </div>
                            @endif
                            <div class="col-sm-10 col-12 d-flex justify-content-center">
                                <div id="current-stage-chart"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <div class="text-center">
                                <p class="card-text mb-50">{{ __('user-dash.Current Fee')}}</p>
                                <span class="font-large-1 font-weight-bold">$ {{ \App\Models\Stage::activePrice() }}</span>
                            </div>
                            <div class="text-center">
                                <p class="card-text mb-50">{{ __('user-dash.Sold Tokens')}}</p>
                                <span class="font-large-1 font-weight-bold">{{ \App\Models\Stage::activeStage()->sells()->where('status','confirmed')->sum('amount') }}</span>
                            </div>
                            <div class="text-center">
                                <p class="card-text mb-50">{{ __('user-dash.Total Distribution')}}</p>
                                <span class="font-large-1 font-weight-bold">{{ \App\Models\Stage::activeStage()->amount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card card-user-timeline">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">{{ __('user-dash.Announcements') }}</h4>
                        </div>
                    </div>
                    <div class="card-body ps ps--active-y" style="height: 300px; overflow-y: visible;">
                        @if(count(\App\Models\Announcement::where('status','1')->get()))
                        <ul class="timeline ml-50">
                            @foreach(\App\Models\Announcement::where('status','1')->get() as $announcement)
                            <li class="timeline-item">
                                <span class="timeline-point timeline-point-info timeline-point-indicator"></span>
                                <div class="timeline-event">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6>{{ $announcement->title }}</h6>
                                        <span class="timeline-event-time mr-1">{{ $announcement->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <p>{{ $announcement->description }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                            <div class="text-center">
                                {{ __('We will announce the topics we want you to know here.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</section>

@endsection
@section('page-scripts')
    <script src="{{ asset('app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>
    <script>
        // RUNNING STAGE CARD
        var $currentStageChart= document.querySelector('#current-stage-chart');
        var currentStageChartOptions;
        var currentStageChart;
        var $textHeadingColor = '#5e5873';
        var $white = '#fff';
        currentStageChartOptions = {
            chart: {
                height: 270,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                    size: 150,
                    offsetY: 20,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '65%'
                    },
                    track: {
                        background: $white,
                        strokeWidth: '100%'
                    },
                    dataLabels: {
                        name: {
                            offsetY: -5,
                            color: $textHeadingColor,
                            fontSize: '1rem'
                        },
                        value: {
                            offsetY: 15,
                            color: $textHeadingColor,
                            fontSize: '1.714rem'
                        }
                    }
                }
            },
            colors: [window.colors.solid.danger],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: [window.colors.solid.primary],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            stroke: {
                dashArray: 8
            },
            series: [{{ round(\App\Models\Stage::activeStage()->sells->sum('amount')*100/ \App\Models\Stage::activeStage()->amount) }}],
            labels: ['{{__('user-dash.Sold')}}']
        };
        currentStageChart = new ApexCharts($currentStageChart, currentStageChartOptions);
        currentStageChart.render();
    </script>
@endsection
