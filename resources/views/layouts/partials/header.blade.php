<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-light bg-gradient-x-grey-blue">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                        class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                            class="feather icon-menu font-large-1"></i></a></li>
                <li class="nav-item"><a class="navbar-brand" href="{{ route('home') }}">
                        <img class="brand-logo" alt="stack admin logo" src="{{ asset('images/logo.png') }}">
                        <h2 class="brand-text">{{ config('app.name', 'CLSG') }}</h2></a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse"
                       data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        @auth
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs"
                               href="#" id="burger"><i class="feather icon-menu"></i></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        @isset($notifications)
                            <notification-component :notifications-count="{{ $notifications_count }}"
                                                    :messages="{{ $notifications }}"></notification-component>
                        @else
                            <notification-component></notification-component>
                        @endif
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link"
                               href="#" data-toggle="dropdown">
                                <div class="avatar avatar-online"><img
                                        src="/app-assets/images/portrait/small/avatar-s-1.png"
                                        alt="avatar">
                                </div>
                                <span class="user-name">{{ auth()->user()->name }}</span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item"
                                   href="{{ route('users.show',auth()->id()) }}"><i
                                        class="feather icon-user"></i> Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                        class="feather icon-power"></i> {{ __('Logout') }}</a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @endauth
    </div>
</nav>
<!-- END: Header-->
