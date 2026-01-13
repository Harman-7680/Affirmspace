<!-- BEGIN: Main Menu -->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true"
    data-img="{{ asset('admin/app-assets/images/backgrounds/02.jpg') }}">

    {{-- Logo --}}
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <img class="brand-logo" src="{{ asset('images/new_logo.png') }}" />
                    <h3 class="brand-text">Welcome Admin</h3>
                </a>
            </li>
            <li class="nav-item d-md-none">
                <a class="nav-link close-navbar"><i class="ft-x"></i></a>
            </li>
        </ul>
    </div>

    <div class="navigation-background"></div>

    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            {{-- USERS --}}
            <li
                class="nav-item {{ request()->routeIs(
                    'admin.counselee',
                    'admin.counselor',
                    'admin.verify.list',
                    'admin.specializations.index',
                    'admin.events',
                    'admin.area-price.index',
                    'sendMessage',
                )
                    ? 'open'
                    : '' }}">
                <a href="javascript:void(0)">
                    <i class="fa fa-users"></i>
                    <span class="menu-title">Users</span>
                </a>

                <ul class="menu-content">

                    {{-- COUNSELEE --}}
                    <li
                        class="nav-item {{ request()->routeIs('admin.counselee', 'admin.verify.list', 'admin.specializations.index') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="menu-item">
                            <i class="fa fa-user"></i>
                            Counselee
                        </a>

                        <ul class="menu-content">

                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.counselee') ? 'active' : '' }}"
                                    href="{{ route('admin.counselee') }}">
                                    <i class="fa fa-users"></i>
                                    All Counselees
                                </a>
                            </li>

                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.verify.list') ? 'active' : '' }}"
                                    href="{{ route('admin.verify.list') }}">
                                    <i class="fa fa-heart"></i>
                                    Dating
                                </a>
                            </li>

                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.specializations.index') ? 'active' : '' }}"
                                    href="{{ route('admin.specializations.index') }}">
                                    <i class="fa fa-brain"></i>
                                    Specializations
                                </a>
                            </li>

                        </ul>
                    </li>

                    {{-- COUNSELOR --}}
                    <li>
                        <a class="menu-item {{ request()->routeIs('admin.counselor') ? 'active' : '' }}"
                            href="{{ route('admin.counselor') }}">
                            <i class="fa fa-user-tie"></i>
                            Counselors
                        </a>
                    </li>

                    {{-- EVENTS --}}
                    <li
                        class="nav-item {{ request()->routeIs('admin.events', 'admin.area-price.index') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="menu-item">
                            <i class="fa fa-calendar-alt"></i>
                            Events
                        </a>

                        <ul class="menu-content">
                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.events') ? 'active' : '' }}"
                                    href="{{ route('admin.events') }}">
                                    <i class="fa fa-list"></i>
                                    Events List
                                </a>
                            </li>

                            <li>
                                <a class="menu-item {{ request()->routeIs('admin.area-price.index') ? 'active' : '' }}"
                                    href="{{ route('admin.area-price.index') }}">
                                    <i class="fa fa-rupee-sign"></i>
                                    Event Pricing
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- CHAT --}}
                    <li>
                        <a class="menu-item {{ request()->routeIs('sendMessage') ? 'active' : '' }}"
                            href="{{ route('sendMessage') }}">
                            <i class="fa fa-envelope me-2"></i>
                            Message
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu -->
