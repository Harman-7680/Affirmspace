<header>
    <a href="/" class="logo-container">
        <img src="images/welcomepage.png" alt="AffirmSpace Logo">
        <span>AffirmSpace</span>
    </a>

    <nav>
        <ul id="nav-menu">
            <li><a href="/"
                    class="{{ request()->routeIs('/') ? 'activeTab font-bold text-blue-600' : '' }}">Home</a></li>
            <li><a href="{{ '/aboutus' }}"
                    class="{{ request()->routeIs('aboutUs') ? 'activeTab font-bold text-blue-600' : '' }}">About Us</a>
            </li>
            <li><a href="{{ '/community' }}"
                    class="{{ request()->routeIs('community') ? 'activeTab font-bold text-blue-600' : '' }}">Community</a>
            </li>

            <li class="dropdown">
                <div class="dropdown-toggle" id="features-toggle">
                    Features
                    <span class="arrow"></span>
                </div>
                <div class="dropdown-content">
                    <a href="/chat">Chat</a>
                    <a href="/dating">Dating</a>
                    <a href="/counselling">Counselling</a>
                    <a href="/events">Events</a>
                </div>
            </li>

            <li><a href="{{ '/contactwithadmin' }}"
                    class="{{ request()->routeIs('contactWithAdmin') ? 'activeTab font-bold text-blue-600' : '' }}">Contact
                    Us</a></li>
            <li><a href="{{ '/login' }}"
                    class="{{ request()->routeIs('login') ? 'activeTab font-bold text-blue-600 nav-btn' : 'nav-btn' }}"
                    class="nav-btn">Get Started</a></li>
        </ul>
    </nav>

    <div class="hamburger" id="hamburger">☰</div>
</header>
