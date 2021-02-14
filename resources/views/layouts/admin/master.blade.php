<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
    @include('layouts.admin.header')
    <body class="vertical-layout vertical-menu-modern  navbar-floating footer-static menu-collapsed @if(auth()->user()->theme == 'dark') dark-layout @endif" data-open="click" data-menu="vertical-menu-modern" data-col="">
        @include('layouts.admin.navbar')
        @include('layouts.admin.mainmenu')

        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h2 class="content-header-title float-left mb-0 border-right-0">@yield('header_title')</h2>
                            </div>
                        </div>
                    </div>
                    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block">
                        <div class="form-group breadcrumb-right">
                            @yield('top_right_button')
                        </div>
                    </div>
                </div>
                <div class="content-body">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
        @include('layouts.admin.footer')
        @include('layouts.admin.scripts')
        @include('layouts.admin.sweetalerts')
    </body>
</html>
