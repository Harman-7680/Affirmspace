<!DOCTYPE html>
<html lang="en">

<head>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GK7P3JDQN0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-GK7P3JDQN0');
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TT8733ZM');
    </script>
    <!-- End Google Tag Manager -->

    @php
        $currentPath = request()->path();
        $fullUrl = request()->fullUrl();

        $staticRoutes = [
            '/',
            'aboutUs',
            'privacy',
            'refundPolicy',
            'contactWithAdmin',
            'terms',
            'blogs',
            'community',
            'chat',
            'chatAndDating',
            'counselling',
            'events',
        ];

        $isStatic = in_array($currentPath, $staticRoutes);
        $isBlog = request()->is('blog/*');
    @endphp

    @if ($isStatic || $isBlog)
        <meta name="robots" content="index, follow">
    @else
        <meta name="robots" content="noindex, nofollow">
    @endif

    @yield('meta')

    @yield('css')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f9fafb;
            color: #222;
            line-height: 1.6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .activeTabDropdown {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white !important;
        }

        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.8rem 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
            color: #333;
        }

        .logo-container img {
            height: 42px;
            width: auto;
        }

        .logo-container span {
            font-size: 1.5rem;
            font-weight: 700;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2.2rem;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        nav a {
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.05rem;
            transition: color 0.2s;
        }

        nav a:hover {
            color: #dd2476;
        }

        .nav-btn {
            padding: 10px 24px;
            border-radius: 30px;
            color: white;
            font-weight: 600;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            text-decoration: none;
        }

        /* ──────────────── DESKTOP DROPDOWN ──────────────── */
        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .arrow {
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid #374151;
            transition: transform 0.25s ease, border-top-color 0.25s;
        }

        .dropdown:hover .arrow {
            transform: rotate(180deg);
            border-top-color: #2563eb;
        }

        .dropdown-content {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: white;
            min-width: 180px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, transform 0.2s;
            pointer-events: none;
        }

        .dropdown:hover .dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
            pointer-events: auto;
        }

        .dropdown-content a {
            display: block;
            padding: 0.8rem 1.4rem;
            color: #374151;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            /* background: #eff6ff; */
            background: linear-gradient(90deg, #ff512f, #dd2476);
            /* color: #2563eb; */
            color: white;
        }

        /* ──────────────── MOBILE ──────────────── */
        .hamburger {
            display: none;
            font-size: 1.9rem;
            cursor: pointer;
            color: #374151;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }

            nav ul {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transform: translateY(-10px);
                opacity: 0;
                visibility: hidden;
                transition: all 0.35s ease;
            }

            nav ul.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }

            nav ul li {
                width: 100%;
                border-bottom: 1px solid #f1f5f9;
            }

            nav ul li:last-child {
                border-bottom: none;
            }

            nav a {
                display: block;
                padding: 1rem 1.5rem;
                font-size: 1.1rem;
            }

            /* ─── Mobile dropdown ──────────────────────────────── */
            .dropdown .dropdown-content {
                position: static;
                transform: none !important;
                box-shadow: none;
                background: #f8fafc;
                max-height: 0;
                overflow: hidden;
                opacity: 0;
                transition: max-height 0.4s ease, opacity 0.3s ease;
            }

            .dropdown.active .dropdown-content {
                max-height: 300px;
                /* ← increase if you add more links later */
                opacity: 1;
            }

            .dropdown.active .arrow {
                transform: rotate(180deg);
                border-top-color: #2563eb;
            }

            .dropdown-toggle {
                padding: 1rem 1.5rem;
                width: 100%;
                justify-content: space-between;
            }

            .nav-btn {
                margin: 1rem auto 1.5rem;
                width: 90%;
                display: block;
                text-align: center;
            }
        }

        .site-footer {
            background: #ffffff;
            padding: 35px 8%;
            border-top: 1px solid #eee;
        }

        .footer-inner {
            max-width: 1200px;
            margin: auto;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .footer-links a {
            text-decoration: none;
            font-size: 0.95rem;
            color: #555;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: #dd2476;
        }

        .footer-copy {
            font-size: 0.85rem;
            color: #777;
        }

        /* this is active class for active tabs */
        .activeTab {
            color: #ff512f !important;
        }
    </style>
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">
    <link rel="canonical" href="{{ request()->is('/') ? url('/') . '/' : url()->current() }}">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TT8733ZM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    {{-- Navbar --}}
    @include('layouts.seo_header')

    @yield('content')

    @include('layouts.seo_footer')

    @yield('script')

    <script>
        // ─── Hamburger menu ───────────────────────────────
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('nav-menu');

        if (hamburger && navMenu) {
            hamburger.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                hamburger.textContent = navMenu.classList.contains('active') ? '✕' : '☰';
            });

            // Close menu on link click (except dropdown toggle)
            document.querySelectorAll('#nav-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    if (!link.closest('.dropdown-toggle')) {
                        navMenu.classList.remove('active');
                        hamburger.textContent = '☰';
                    }
                });
            });
        }

        // ─── Mobile Features dropdown ───────────────────────────────
        function initMobileDropdown() {
            const toggle = document.getElementById('features-toggle');
            if (!toggle) return;

            toggle.addEventListener('click', function(e) {
                // Only handle on mobile
                if (window.innerWidth > 768) return;

                e.preventDefault();
                e.stopPropagation();

                const dropdown = this.closest('.dropdown');
                dropdown.classList.toggle('active');
            });
        }

        initMobileDropdown();
        window.addEventListener('resize', initMobileDropdown);
    </script>
</body>

</html>
