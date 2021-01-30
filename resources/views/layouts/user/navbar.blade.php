<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                    <a class="dropdown-item" href="javascript:void(0);" data-language="en"><i class="flag-icon flag-icon-us"></i> English</a>
                </div>
            </li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{ Auth::user()->name }}</span>
                        <span class="user-status">{{ Auth::user()->getRoleNames()->first() }}</span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" style="height: 40px; width: 40px;">
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    @hasanyrole('Super Admin|Admin|Editor|Accountant')
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="mr-50" data-feather="lock"></i> {{ __('menu.Administration') }}</a>
                    @endhasanyrole
                    <a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="mr-50" data-feather="user"></i> {{ __('menu.User Dashboard') }}</a>
                    <a class="dropdown-item" href="{{ route('user.profile.index') }}"><i class="mr-50" data-feather="settings"></i> {{ __('menu.Profile') }}</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();"><i class="mr-50" data-feather="power"></i> {{ __('menu.Logout') }}</a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
