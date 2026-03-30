<header>
    <a href="{{ route('/') }}" class="logo-container">
        <img src="{{ asset('images/welcomepage.png') }}" alt="AffirmSpace Logo">
        <span>AffirmSpace</span>
    </a>

    @if (!Auth::check())
        <nav>
            <ul id="nav-menu">

                <li>
                    <a href="{{ url('/') }}"
                        class="{{ request()->is('/') ? 'activeTab font-bold text-blue-600' : '' }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route('aboutUs') }}"
                        class="{{ request()->routeIs('aboutUs') ? 'activeTab font-bold text-blue-600' : '' }}">
                        About Us
                    </a>
                </li>

                <li>
                    <a href="{{ route('community') }}"
                        class="{{ request()->routeIs('community') ? 'activeTab font-bold text-blue-600' : '' }}">
                        Community
                    </a>
                </li>

                <li class="dropdown">
                    <div class="dropdown-toggle" id="features-toggle">
                        Features
                        <span class="arrow"></span>
                    </div>

                    <div class="dropdown-content">
                        <a href="{{ route('chat') }}"
                            class="{{ request()->routeIs('chat') ? 'activeTabDropdown font-bold text-blue-600' : '' }}">
                            Chat
                        </a>

                        <a href="{{ route('chatAndDating') }}"
                            class="{{ request()->routeIs('chatAndDating') ? 'activeTabDropdown font-bold text-blue-600' : '' }}">
                            Dating
                        </a>

                        <a href="{{ route('counselling') }}"
                            class="{{ request()->routeIs('counselling') ? 'activeTabDropdown font-bold text-blue-600' : '' }}">
                            Counselling
                        </a>

                        <a href="{{ route('events') }}"
                            class="{{ request()->routeIs('events') ? 'activeTabDropdown font-bold text-blue-600' : '' }}">
                            Events
                        </a>
                    </div>
                </li>

                <li>
                    <a href="{{ route('contactWithAdmin') }}"
                        class="{{ request()->routeIs('contactWithAdmin') ? 'activeTab font-bold text-blue-600' : '' }}">
                        Contact Us
                    </a>
                </li>

                <li>
                    @if (Auth::check())
                        <a href="{{ route('feed') }}"
                            class="{{ request()->routeIs('feed') ? 'activeTab font-bold text-blue-600 nav-btn' : 'nav-btn' }}">
                            Go to Feed
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="{{ request()->routeIs('login') ? 'activeTab font-bold text-blue-600 nav-btn' : 'nav-btn' }}">
                            Login
                        </a>
                    @endif
                </li>

            </ul>
        </nav>
    @endif

    <div class="hamburger" id="hamburger">☰</div>
</header>
