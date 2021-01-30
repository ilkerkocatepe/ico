<ul class="menu-content">
    @if(isset($menu))
        @foreach($menu as $submenu)
            <li class="{{ $submenu->route === Route::currentRouteName() ? 'active' : '' }}">
                <a href="{{isset($submenu->route) ? route($submenu->route):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
                    @if(isset($submenu->icon))
                        <i  data-feather="{{$submenu->icon}}"></i>
                    @endif
                    <span class="menu-item">{{ __('menu.'.$submenu->name) }}</span>
                </a>
                @if (isset($submenu->submenu))
                    @include('layouts.admin.submenu', ['menu' => $submenu->submenu])
                @endif
            </li>
        @endforeach
    @endif
</ul>
