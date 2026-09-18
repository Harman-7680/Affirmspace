<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GK7P3JDQN0"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-GK7P3JDQN0');
    </script>
    <!-- End Google Analytics -->


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
                'https://www.googletagmanager.com/gtm.js?id=' +
                i +
                dl;

            f.parentNode.insertBefore(j, f);

        })(window, document, 'script', 'dataLayer', 'GTM-TT8733ZM');
    </script>
    <!-- End Google Tag Manager -->


    @php

        $routeName = request()->route()->getName();

        $indexRoutes = [
            '/',
            'terms',
            'aboutUs',
            'privacy',
            'refundPolicy',
            'contactWithAdmin',
            'blogs',
            'community',
            'chat',
            'chatAndDating',
            'counselling',
            'events',
            'blog.detail',
            'apps',
        ];

        $isIndex = in_array($routeName, $indexRoutes);

    @endphp


    @if ($isIndex)
        <meta name="robots" content="index, follow">
    @else
        <meta name="robots" content="noindex, nofollow">
    @endif


    @yield('meta')


    <meta name="p:domain_verify" content="3a38221ab36dc5451f9667240b53b17f" />


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    @yield('css')


    <style>
        /* =========================================================
           GLOBAL RESET
        ========================================================= */

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


        /* =========================================================
           ACTIVE DROPDOWN TAB
        ========================================================= */

        .activeTabDropdown {
            background: linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            color: white !important;
        }


        /* =========================================================
           HEADER
        ========================================================= */

        header {
            background: white;

            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.08);

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


        /* =========================================================
           NAVIGATION
        ========================================================= */

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

            transition: color 0.2s ease;
        }


        nav a:hover {
            color: #dd2476;
        }


        /* =========================================================
           NAVIGATION BUTTON
        ========================================================= */

        .nav-btn {
            padding: 10px 24px;

            border-radius: 30px;

            color: white;

            font-weight: 600;

            background:
                linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            text-decoration: none;
        }


        /* =========================================================
           DESKTOP DROPDOWN
        ========================================================= */

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

            border-left:
                5px solid transparent;

            border-right:
                5px solid transparent;

            border-top:
                6px solid #374151;

            transition:
                transform 0.25s ease,
                border-top-color 0.25s ease;
        }


        .dropdown:hover .arrow {

            transform:
                rotate(180deg);

            border-top-color:
                #2563eb;
        }


        .dropdown-content {

            position: absolute;

            top: 100%;

            left: 50%;

            transform:
                translateX(-50%) translateY(10px);

            background: white;

            min-width: 180px;

            box-shadow:
                0 8px 24px rgba(0, 0, 0, 0.15);

            border-radius: 8px;

            overflow: hidden;

            opacity: 0;

            visibility: hidden;

            transition:
                opacity 0.2s ease,
                transform 0.2s ease;

            pointer-events: none;
        }


        .dropdown:hover .dropdown-content {

            opacity: 1;

            visibility: visible;

            transform:
                translateX(-50%) translateY(0);

            pointer-events: auto;
        }


        .dropdown-content a {

            display: block;

            padding:
                0.8rem 1.4rem;

            color: #374151;

            text-decoration: none;
        }


        .dropdown-content a:hover {

            background:
                linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            color: white;
        }


        /* =========================================================
           MOBILE HEADER
        ========================================================= */

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

                box-shadow:
                    0 4px 12px rgba(0, 0, 0, 0.1);

                transform:
                    translateY(-10px);

                opacity: 0;

                visibility: hidden;

                transition:
                    all 0.35s ease;
            }


            nav ul.active {

                transform:
                    translateY(0);

                opacity: 1;

                visibility: visible;
            }


            nav ul li {

                width: 100%;

                border-bottom:
                    1px solid #f1f5f9;
            }


            nav ul li:last-child {

                border-bottom: none;
            }


            nav a {

                display: block;

                padding:
                    1rem 1.5rem;

                font-size: 1.1rem;
            }


            /* =====================================================
               MOBILE DROPDOWN
            ===================================================== */

            .dropdown .dropdown-content {

                position: static;

                transform: none !important;

                box-shadow: none;

                background: #f8fafc;

                max-height: 0;

                overflow: hidden;

                opacity: 0;

                transition:
                    max-height 0.4s ease,
                    opacity 0.3s ease;
            }


            .dropdown.active .dropdown-content {

                max-height: 300px;

                opacity: 1;
            }


            .dropdown.active .arrow {

                transform:
                    rotate(180deg);

                border-top-color:
                    #2563eb;
            }


            .dropdown-toggle {

                padding:
                    1rem 1.5rem;

                width: 100%;

                justify-content:
                    space-between;
            }


            .nav-btn {

                margin:
                    1rem auto 1.5rem;

                width: 90%;

                display: block;

                text-align: center;
            }

        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .site-footer {

            background: #ffffff;

            padding: 35px 8%;

            border-top:
                1px solid #eee;
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


        /* =========================================================
           ACTIVE TAB
        ========================================================= */

        .activeTab {
            color: #ff512f !important;
        }


        /* =========================================================
           STICKY APP BADGES
           
           BOTTOM RIGHT OF SCREEN
           
           GOOGLE PLAY = ACTIVE
           APP STORE = COMMENTED OUT
        ========================================================= */

        .as-sticky-app-buttons {

            position: fixed;

            right: 18px;

            bottom: 22px;

            z-index: 9999;

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            gap: 10px;
        }


        .as-sticky-app-buttons>a {

            display: block;

            text-decoration: none;

            line-height: 0;
        }


        .as-sticky-app-badge {

            display: block;

            width: 165px;

            height: auto;

            border-radius: 8px;

            box-shadow:
                0 8px 24px rgba(0, 0, 0, 0.18);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .as-sticky-app-badge:hover {

            transform:
                translateY(-4px);

            box-shadow:
                0 12px 30px rgba(0, 0, 0, 0.22);
        }


        /* =========================================================
           MOBILE APP BADGE
        ========================================================= */

        @media (max-width: 768px) {

            .as-sticky-app-buttons {

                right: 12px;

                bottom: 16px;

                gap: 8px;
            }


            .as-sticky-app-badge {

                width: 145px;
            }


            .as-sticky-app-badge:hover {

                transform:
                    translateY(-3px);
            }

        }


        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 480px) {

            .as-sticky-app-buttons {

                right: 10px;

                bottom: 14px;
            }


            .as-sticky-app-badge {

                width: 135px;
            }

        }


        /* =========================================================
           VERY SMALL MOBILE
        ========================================================= */

        @media (max-width: 360px) {

            .as-sticky-app-buttons {

                right: 8px;

                bottom: 12px;
            }


            .as-sticky-app-badge {

                width: 125px;
            }

        }
    </style>


    <!-- Favicon -->
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">


    <!-- Canonical -->
    <link rel="canonical" href="{{ request()->is('/') ? url('/') . '/' : url()->current() }}">

</head>


<body>


    <!-- =========================================================
         GOOGLE TAG MANAGER NOSCRIPT
    ========================================================= -->

    <noscript>

        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TT8733ZM" height="0" width="0"
            style="display:none;visibility:hidden">
        </iframe>

    </noscript>

    <!-- End Google Tag Manager noscript -->


    {{-- =========================================================
         NAVBAR
    ========================================================= --}}

    @include('layouts.seo_header')


    {{-- =========================================================
         PAGE CONTENT
    ========================================================= --}}

    @yield('content')


    {{-- =========================================================
         FOOTER
    ========================================================= --}}

    @include('layouts.seo_footer')


    {{-- =========================================================
         STICKY APP DOWNLOAD BADGES
         
         These stay fixed to the bottom-right of the screen.
         
         Google Play is currently active.
         
         Apple App Store is commented out until
         the iOS App Store listing is live.
    ========================================================= --}}

    <div class="as-sticky-app-buttons">


        {{-- =====================================================
             APP STORE — COMMENTED OUT FOR NOW
             
             When iOS is live, remove the <!-- and --> comments.
             
             Replace YOUR_APP_STORE_LINK with the real
             Apple App Store URL.
        ===================================================== --}}

        <!--

        <a
            href="YOUR_APP_STORE_LINK"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Download AffirmSpace on the App Store">

            <img
                src="{{ asset('images/applebadge.png') }}"
                class="as-sticky-app-badge"
                alt="Download AffirmSpace on the App Store"
            >

        </a>

        -->


        {{-- =====================================================
             GOOGLE PLAY — ACTIVE
        ===================================================== --}}

        <a href="https://play.google.com/store/apps/details?id=com.affirmspace.app" target="_blank"
            rel="noopener noreferrer" aria-label="Download AffirmSpace on Google Play">

            <img src="{{ asset('images/googlebadge.png') }}" class="as-sticky-app-badge"
                alt="Get AffirmSpace on Google Play">

        </a>


    </div>


    {{-- =========================================================
         PAGE-SPECIFIC SCRIPTS
    ========================================================= --}}

    @yield('script')


    <script>
        /* =========================================================
                   HAMBURGER MENU
                ========================================================= */

        const hamburger =
            document.getElementById('hamburger');

        const navMenu =
            document.getElementById('nav-menu');


        if (hamburger && navMenu) {

            hamburger.addEventListener('click', () => {

                navMenu.classList.toggle('active');


                hamburger.textContent =
                    navMenu.classList.contains('active') ?
                    '✕' :
                    '☰';

            });


            /*
             * Close menu when a normal link
             * is clicked.
             */

            document
                .querySelectorAll('#nav-menu a')
                .forEach(link => {

                    link.addEventListener('click', () => {

                        if (
                            !link.closest(
                                '.dropdown-toggle'
                            )
                        ) {

                            navMenu.classList.remove(
                                'active'
                            );

                            hamburger.textContent =
                                '☰';
                        }

                    });

                });

        }


        /* =========================================================
           MOBILE FEATURES DROPDOWN
        ========================================================= */

        function initMobileDropdown() {

            const toggle =
                document.getElementById(
                    'features-toggle'
                );


            if (!toggle) return;


            toggle.addEventListener(
                'click',
                function(e) {

                    /*
                     * Only handle dropdown
                     * behavior on mobile.
                     */

                    if (
                        window.innerWidth > 768
                    ) {
                        return;
                    }


                    e.preventDefault();

                    e.stopPropagation();


                    const dropdown =
                        this.closest(
                            '.dropdown'
                        );


                    if (dropdown) {

                        dropdown.classList.toggle(
                            'active'
                        );

                    }

                }
            );

        }


        initMobileDropdown();


        window.addEventListener(
            'resize',
            initMobileDropdown
        );
    </script>


</body>

</html>
