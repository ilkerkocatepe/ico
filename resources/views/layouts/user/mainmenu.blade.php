<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('user.dashboard') }}">
                    <span class="brand-logo">
                        <img src="{{ asset('assets/images/logo/logo.png') }}">
                    </span>
                    <h2 class="brand-text">{{ env('APP_NAME') }}</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    @php
        Route::currentRouteName() === 'user.dashboard' ? 'active' : '';
    @endphp
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- Foreach menu item starts --}}
            @if(isset($menuData[1]))
                @foreach($menuData[1]->menu as $menu)
                    @if(isset($menu->navheader))
                        <li class="navigation-header">
                            <span>{{ __('menu.'.$menu->navheader) }}</span>
                            <i data-feather="more-horizontal"></i>
                        </li>
                    @else
                        @php
                            $custom_classes = "";
                            if(isset($menu->classlist)) {
                            $custom_classes = $menu->classlist;
                            }
                        @endphp
                        <li class="nav-item {{ \Route::currentRouteName() === $menu->route ? 'active' : '' }} {{ $custom_classes }}">
                            <a href="{{isset($menu->route)? route($menu->route):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($menu->newTab) ? '_blank':'_self'}}">
                                <i class="fas fa-{{ $menu->icon }}"></i>
                                <span class="menu-title text-truncate">{{ __('menu.'.$menu->name) }}</span>
                                @if (isset($menu->badge))
                                    <?php $badgeClasses = "badge badge-pill badge-light-primary ml-auto mr-1" ?>
                                    <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }} ">{{$menu->badge}}</span>
                                @endif
                            </a>
                            @if(isset($menu->submenu))
                                @include('layouts.user.submenu', ['menu' => $menu->submenu])
                            @endif
                        </li>
                    @endif
                @endforeach
            @endif
            {{-- Foreach menu item ends --}}
        </ul>
    </div>
</div>
