<!-- sidebar -->
<div id="site__sidebar"
    class="fixed top-0 left-0 z-[99] pt-[--m-top] overflow-hidden transition-transform xl:duration-500 max-xl:w-full max-xl:-translate-x-full">

    <!-- sidebar inner -->
    <div
        class="p-2 max-xl:bg-white shadow-sm 2xl:w-72 sm:w-64 w-[80%] h-[calc(100vh-64px)] relative z-30 max-lg:border-r dark:max-xl:!bg-slate-700 dark:border-slate-700">
        <div class="pr-4" data-simplebar>
            <nav id="side">
                <ul>
                    @php
                        $current = strtolower(Route::currentRouteName());
                    @endphp

                    {{-- <li class="{{ $current === 'feed' ? 'active' : '' }}">
                        <a href="{{ route('feed') }}">
                            <img src="{{ asset('images/icons/home.png') }}" alt="feeds" class="w-6">
                            <span> Feed </span>
                        </a>
                    </li>
                    <li class="{{ $current === 'messages' ? 'active' : '' }}">
                        <a href="{{ route('messages') }}">
                            <img src="{{ asset('images/icons/home.png') }}" alt="messages" class="w-5">
                            <span> messages </span>
                        </a>
                    </li>
                    <li class="{{ $current === 'event' ? 'active' : '' }}">
                        <a href="{{ route('event') }}">
                            <img src="{{ asset('images/icons/home.png') }}" alt="event" class="w-6">
                            <span> Explore Friends </span>
                        </a>
                    </li>
                    <li class="{{ $current === 'video' ? 'active' : '' }}">
                        <a href="{{ route('video') }}">
                            <img src="{{ asset('images/icons/home.png') }}" alt="video" class="w-6">
                            <span> Explore Counselors </span>
                        </a>
                    </li> --}}

                    <h3 class="my-2 mx-2">Profile</h3>
                    <li class="{{ $current === 'feed' ? 'active' : '' }}">
                        <a href="{{ route('feed') }}"
                            class="{{ $current === 'feed' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="home" class="w-6 h-6 {{ $current === 'feed' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'feed' ? 'active' : '' }}">Feed</span>
                        </a>
                    </li>

                    <li class="{{ $current === 'messages' ? 'active' : '' }}">
                        <a href="{{ route('messages') }}"
                            class="{{ $current === 'messages' ? 'active' : '' }}  flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="message-square"
                                class="w-6 h-6 {{ $current === 'messages' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'messages' ? 'active' : '' }}">Messages</span>
                        </a>
                    </li>

                    <li class="{{ $current === 'event' ? 'active' : '' }}">
                        <a href="{{ route('event') }}"
                            class="{{ $current === 'event' ? 'active' : '' }}  flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="users"
                                class="w-6 h-6 {{ $current === 'event' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'event' ? 'active' : '' }}">Search Friends</span>
                        </a>
                    </li>

                    <li class="{{ $current === 'notifications' ? 'active' : '' }}">
                        <a href="{{ route('notifications') }}"
                            class="{{ $current === 'notifications' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="party-popper"
                                class="w-6 h-6 {{ $current === 'notifications' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'notifications' ? 'active' : '' }}">Events</span>
                        </a>
                    </li>

                    <li class="{{ $current === 'timeline' ? 'active' : '' }}">
                        <a href="{{ route('timeline') }}"
                            class="{{ $current === 'timeline' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="user"
                                class="w-6 h-6 {{ $current === 'timeline' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'timeline' ? 'active' : '' }}">My Profile</span>
                        </a>
                    </li>

                    @php
                        $activeRoutes = ['pages', 'dating.verification.wait', 'dating.profile', 'dating.upload.photos'];
                    @endphp

                    <li class="{{ in_array($current, $activeRoutes) ? 'active' : '' }}">
                        <a href="{{ route('pages') }}"
                            class="dating-btn relative flex items-center gap-2 px-3 py-2 rounded-lg transition group">

                            <!-- HEART ICON (always animating by default) -->
                            <i data-lucide="heart"
                                class="heart-icon w-6 h-6 transition-all duration-300 {{ in_array($current, $activeRoutes) ? 'active-heart' : '' }}"></i>

                            <!-- TEXT -->
                            <span
                                class="dating-text transition-all duration-300 {{ in_array($current, $activeRoutes) ? 'active-text' : '' }}">
                                Dating
                            </span>

                            <!-- Always-available subtle glow element behind icon (non-blocking) -->
                            <span class="icon-glow" aria-hidden="true"></span>
                        </a>
                    </li>

                    <hr class="my-2">
                    <h3 class="my-2 mx-2">Counselling</h3>
                    <li class="{{ $current === 'video' ? 'active' : '' }}">
                        <a href="{{ route('video') }}"
                            class="{{ $current === 'video' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="stethoscope"
                                class="w-6 h-6 {{ $current === 'video' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'video' ? 'active' : '' }}">Explore Counselors</span>
                        </a>
                    </li>

                    <li class="{{ $current === 'blog' ? 'active' : '' }}">
                        <a href="{{ route('blog') }}"
                            class="{{ $current === 'blog' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="life-buoy"
                                class="w-6 h-6 {{ $current === 'blog' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'blog' ? 'active' : '' }}">My Counsellings</span>
                        </a>
                    </li>

                    <hr class="my-2">
                    <h3 class="my-2 mx-2">Room</h3>
                    <li class="{{ $current === 'upgrade' ? 'active' : '' }}">
                        <a href="{{ route('upgrade') }}"
                            class="{{ $current === 'upgrade' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="message-circle-plus"
                                class="w-6 h-6 {{ $current === 'upgrade' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'upgrade' ? 'active' : '' }}">Create Room</span>
                        </a>
                    </li>

                    <li class="{{ $current === 'groups' ? 'active' : '' }}">
                        <a href="{{ route('groups') }}"
                            class="{{ $current === 'groups' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="log-in"
                                class="w-6 h-6 {{ $current === 'groups' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === 'groups' ? 'active' : '' }}">Join Room</span>
                        </a>
                    </li>

                    {{-- <li class="{{ $current === 'groups' ? 'active' : '' }}">
                        <a href="{{ route('groups') }}">
                            <img src="{{ asset('images/icons/home.png') }}" alt="groups" class="w-6">
                            <span> Groups </span>
                        </a>
                    </li> --}}

                    <hr class="my-2">
                    <h3 class="my-2 mx-2">Account Settings</h3>

                    <li class="{{ Route::is('profile.edit') ? 'active' : '' }}">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2 {{ Route::is('profile.edit') ? 'active' : '' }} hover:text-blue-600 transition">
                            <i data-lucide="sliders-horizontal"
                                class="w-6 h-6 {{ Route::is('profile.edit') ? 'icon-bg-remove' : '' }}"></i>
                            <span>My Account</span>
                        </a>
                    </li>

                    <hr class="my-2">
                    <li class="{{ $current === '2' ? 'active' : '' }}">
                        <a href="#"
                            onclick="event.preventDefault(); if(confirm('Are you sure you want to log out?')) { document.getElementById('logout-form').submit(); }"
                            class="{{ $current === '2' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="door-open"
                                class="w-6 h-6 {{ $current === '2' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === '2' ? 'active' : '' }}">Log Out</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </li>
                    {{-- <li style="" class="{{ $current === '2' ? 'active' : '' }} logout-btn">
                        <a href="{{ route('video') }}"
                            class="{{ $current === '2' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="door-open"
                                class="w-6 h-6 {{ $current === '2' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === '2' ? 'active' : '' }}">Log Out</span>
                        </a>
                    </li> --}}

                    {{-- <li style="" class="{{ $current === '2' ? 'active' : '' }} logout-btn">
                        <a href="#"
                            onclick="event.preventDefault(); if(confirm('Are you sure you want to log out?')) { document.getElementById('logout-form').submit(); }"
                            class="{{ $current === '2' ? 'active' : '' }} flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="door-open"
                                class="w-6 h-6 {{ $current === '2' ? 'icon-bg-remove' : '' }}"></i>
                            <span class="{{ $current === '2' ? 'active' : '' }}">Log Out</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </li> --}}

                    <!-- Load Lucide and Initialize Icons -->
                    <script src="https://unpkg.com/lucide@latest"></script>
                    <script>
                        lucide.createIcons();
                    </script>

                </ul>
            </nav>
        </div>
    </div>

    <!-- sidebar overly -->
    <div id="site__sidebar__overly" class="absolute top-0 left-0 z-20 w-screen h-screen xl:hidden backdrop-blur-sm"
        uk-toggle="target: #site__sidebar ; cls :!-translate-x-0">
    </div>
</div>

<style>
    .active {
        background: linear-gradient(90deg, #ff512f, #dd2476);
        border-radius: 15px;
    }

    .active span {
        color: white;
    }

    .icon-bg-remove {
        background: transparent !important;
        color: white !important;
    }

    .logout-btn {
        position: absolute;
        bottom: 0;
        width: 100%;
    }
</style>

<style>
    /* ---- animations ---- */
    @keyframes gentlePulse {
        0% {
            transform: scale(1);
            opacity: 0.9;
        }

        40% {
            transform: scale(1.07);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 0.9;
        }
    }

    @keyframes strongHeartbeat {
        0% {
            transform: scale(1);
        }

        25% {
            transform: scale(1.18);
        }

        40% {
            transform: scale(1.06);
        }

        60% {
            transform: scale(1.22);
        }

        100% {
            transform: scale(1);
        }
    }

    @keyframes glowPulse {
        0% {
            transform: scale(1);
            opacity: 0.18;
        }

        50% {
            transform: scale(1.6);
            opacity: 0.45;
        }

        100% {
            transform: scale(1);
            opacity: 0.18;
        }
    }

    /* ---- base styles for the link ---- */
    .dating-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: visible;
    }

    /* ---- icon: always gently pulsing ---- */
    .heart-icon {
        display: inline-block;
        transform-origin: center;
        animation: gentlePulse 2.2s ease-in-out infinite;
        color: #e74c89;
        /* subtle default tint; change as you like */
    }

    /* ---- stronger heartbeat when this page is active ---- */
    .active-heart {
        animation: strongHeartbeat 1.4s ease-in-out infinite;
        color: #ff2e6d !important;
    }

    /* ---- text styling ---- */
    .dating-text {
        color: inherit;
        transition: color .18s, font-weight .18s;
    }

    .active-text {
        font-weight: 700;
        color: #ff2e6d !important;
    }

    /* ---- glow element behind icon (subtle, always present) ---- */
    .icon-glow {
        position: absolute;
        left: 10px;
        /* adjust to line up under icon */
        top: 50%;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        border-radius: 999px;
        /* background: #ff4fa0; */
        filter: blur(10px);
        opacity: 0.12;
        pointer-events: none;
        /* never block clicks */
        transition: opacity .25s, transform .25s;
        z-index: -1;
    }

    /* ---- hover: make icon pop and glow stronger ---- */
    .dating-btn:hover .heart-icon {
        transform: scale(1.25);
        filter: drop-shadow(0 6px 14px rgba(255, 82, 140, 0.18));
    }

    /* strengthen glow on hover */
    .dating-btn:hover .icon-glow {
        opacity: 0.28;
        transform: translateY(-50%) scale(1.25);
    }

    /* ---- if you still want a different glow when active + hovering ---- */
    .active-heart+.dating-text,
    .dating-btn:has(.active-heart):hover .dating-text {
        /* selector fallback: some browsers don't support :has yet */
        color: #ff2e6d;
        font-weight: 700;
    }

    /* ---- fallback for browsers without :has: keep hover behavior via class (works everywhere) */
    .dating-btn.active-hover .dating-text {
        color: #ff2e6d;
        font-weight: 700;
    }
</style>
