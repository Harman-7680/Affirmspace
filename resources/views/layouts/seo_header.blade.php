{{-- <style>
    /* =========================================================
       AFFIRMSPACE HEADER
       ========================================================= */

    .as-main-header {
        width: 100%;
        height: 74px;
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 0 5.2%;

        background: #ffffff;
        border-bottom: 1px solid #eeeeee;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);

        position: relative;
        z-index: 99999;

        font-family: 'Inter', Arial, sans-serif;
    }

    .as-main-header *,
    .as-main-header *::before,
    .as-main-header *::after {
        box-sizing: border-box;
    }


    /* =========================================================
       LOGO
       ========================================================= */

 /* =========================================================
   LOGO – FIXED (image always shows)
   ========================================================= */

.as-header-logo {
    display: inline-flex !important;
    align-items: center !important;
    gap: 11px !important;
    flex-shrink: 0 !important;
    text-decoration: none !important;
    color: #333333 !important;
}

.as-header-logo img {
    display: block !important;
    width: 42px !important;
    height: 42px !important;
    min-width: 42px !important;
    min-height: 42px !important;
    max-width: 42px !important;
    max-height: 42px !important;
    object-fit: contain !important;
    flex-shrink: 0 !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.as-header-logo-name {
    color: #333333 !important;
    font-size: 22px !important;
    line-height: 1 !important;
    font-weight: 800 !important;
    letter-spacing: -0.4px !important;
    white-space: nowrap !important;
}


    /* =========================================================
       DESKTOP NAVIGATION
       ========================================================= */

    .as-header-nav {
        height: 100%;

        display: flex;
        align-items: center;

        margin-left: auto;
    }

    .as-header-nav-list {
        height: 100%;

        display: flex;
        align-items: center;

        gap: 30px;

        margin: 0;
        padding: 0;

        list-style: none;
    }

    .as-header-nav-item {
        height: 100%;

        display: flex;
        align-items: center;

        position: relative;

        margin: 0;
        padding: 0;

        list-style: none;
    }


    /* =========================================================
       NORMAL NAV LINKS
       ========================================================= */

    .as-header-nav-link {
        height: 100%;

        display: inline-flex;
        align-items: center;

        position: relative;

        color: #3d4654 !important;

        font-size: 15px;
        line-height: 1;
        font-weight: 500;

        text-decoration: none !important;
        white-space: nowrap;

        transition: color 0.2s ease;
    }

    .as-header-nav-link:hover {
        color: #dd2476 !important;
    }

    .as-header-nav-link.as-header-active {
        color: #dd2476 !important;
        font-weight: 600;
    }

    .as-header-nav-link.as-header-active::after {
        content: "";

        position: absolute;

        left: 0;
        right: 0;
        bottom: 0;

        height: 3px;

        border-radius: 4px 4px 0 0;

        background: linear-gradient(90deg, #ff512f, #dd2476);
    }


    /* =========================================================
       FEATURES DROPDOWN
       ========================================================= */

    .as-header-features {
        position: relative;

        height: 100%;

        display: flex;
        align-items: center;
    }

    .as-header-features-summary {
        height: 100%;

        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding: 0;
        margin: 0;

        border: 0;

        background: transparent;

        color: #3d4654;

        font-family: inherit;
        font-size: 15px;
        font-weight: 500;

        cursor: pointer;

        list-style: none;
        white-space: nowrap;
    }

    .as-header-features-summary::-webkit-details-marker {
        display: none;
    }

    .as-header-features-summary::marker {
        display: none;
    }

    .as-header-feature-arrow {
        width: 7px;
        height: 7px;

        display: inline-block;

        border-right: 1.7px solid currentColor;
        border-bottom: 1.7px solid currentColor;

        transform: rotate(45deg) translateY(-2px);

        transition: transform 0.2s ease;
    }

    .as-header-features[open] .as-header-feature-arrow {
        transform: rotate(225deg) translateY(-1px);
    }

    .as-header-features-dropdown {
        position: absolute;

        top: calc(100% + 1px);
        left: 50%;

        width: 196px;

        padding: 10px;

        transform: translateX(-50%);

        background: #ffffff;

        border-radius: 0 0 8px 8px;

        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.14);

        z-index: 100000;
    }

    .as-header-dropdown-link {
        width: 100%;
        min-height: 42px;

        display: flex;
        align-items: center;

        gap: 13px;

        padding: 9px 12px;

        border-radius: 6px;

        color: #4b5563 !important;

        font-size: 14px;
        font-weight: 500;

        text-decoration: none !important;

        transition:
            background 0.2s ease,
            color 0.2s ease;
    }

    .as-header-dropdown-link:hover {
        background: #fff2f6;
        color: #dd2476 !important;
    }

    .as-header-dropdown-icon {
        width: 23px;

        display: inline-flex;
        justify-content: center;

        font-size: 17px;

        color: #dd2476;
    }

    .as-header-dropdown-link:nth-child(1) .as-header-dropdown-icon {
        color: #ef5aa1;
    }

    .as-header-dropdown-link:nth-child(2) .as-header-dropdown-icon {
        color: #e94078;
    }

    .as-header-dropdown-link:nth-child(3) .as-header-dropdown-icon {
        color: #8d4fd1;
    }

    .as-header-dropdown-link:nth-child(4) .as-header-dropdown-icon {
        color: #ff6045;
    }


    /* =========================================================
       DOWNLOAD BUTTON
       ========================================================= */

    .as-header-download {
        height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 0 23px;

        border: 0;
        border-radius: 25px;

        background: linear-gradient(90deg, #ff512f, #dd2476);

        color: #ffffff !important;

        font-size: 15px;
        font-weight: 700;

        text-decoration: none !important;

        white-space: nowrap;

        box-shadow: 0 5px 14px rgba(221, 36, 118, 0.16);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .as-header-download:hover {
        color: #ffffff !important;

        transform: translateY(-1px);

        box-shadow: 0 8px 20px rgba(221, 36, 118, 0.23);
    }

    .as-header-download-icon {
        font-size: 13px;
    }


    /* =========================================================
       LOGIN BUTTON
       ========================================================= */

    .as-header-login {
        height: 46px;
        min-width: 89px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 0 22px;

        border: 1.5px solid #dd2476;
        border-radius: 25px;

        background: #ffffff;

        color: #dd2476 !important;

        font-size: 15px;
        font-weight: 600;

        text-decoration: none !important;

        white-space: nowrap;

        transition:
            background 0.2s ease,
            color 0.2s ease,
            transform 0.2s ease;
    }

    .as-header-login:hover {
        background: linear-gradient(90deg, #ff512f, #dd2476);

        color: #ffffff !important;

        border-color: transparent;

        transform: translateY(-1px);
    }


    /* =========================================================
       MOBILE MENU CONTROL
       ========================================================= */

    .as-header-menu-checkbox {
        display: none !important;
    }

    .as-header-hamburger {
        display: none;

        width: 42px;
        height: 42px;

        align-items: center;
        justify-content: center;

        cursor: pointer;

        position: relative;

        z-index: 100002;
    }

    .as-header-hamburger-lines,
    .as-header-hamburger-lines::before,
    .as-header-hamburger-lines::after {
        width: 23px;
        height: 2px;

        background: #333333;

        border-radius: 2px;

        position: absolute;

        display: block;

        transition:
            transform 0.25s ease,
            opacity 0.25s ease;
    }

    .as-header-hamburger-lines::before,
    .as-header-hamburger-lines::after {
        content: "";

        left: 0;
    }

    .as-header-hamburger-lines::before {
        transform: translateY(-7px);
    }

    .as-header-hamburger-lines::after {
        transform: translateY(7px);
    }


    /* =========================================================
       TABLET
       ========================================================= */

    @media (max-width: 1050px) {

        .as-main-header {
            padding-left: 4%;
            padding-right: 4%;
        }

        .as-header-nav-list {
            gap: 20px;
        }

        .as-header-download {
            padding-left: 18px;
            padding-right: 18px;
        }
    }


    /* =========================================================
       MOBILE
       ========================================================= */

    @media (max-width: 850px) {

        .as-main-header {
            height: 68px;

            padding: 0 20px;

            position: relative;

            z-index: 100000;
        }

        .as-header-logo img {
            width: 40px;
            height: 40px;
        }

        .as-header-logo-name {
            font-size: 20px;
        }


        /* SHOW HAMBURGER */

        .as-header-hamburger {
            display: flex;
        }


        /* HAMBURGER -> X */

        .as-header-menu-checkbox:checked + .as-header-hamburger
        .as-header-hamburger-lines {
            background: transparent;
        }

        .as-header-menu-checkbox:checked + .as-header-hamburger
        .as-header-hamburger-lines::before {
            transform: rotate(45deg);
        }

        .as-header-menu-checkbox:checked + .as-header-hamburger
        .as-header-hamburger-lines::after {
            transform: rotate(-45deg);
        }


        /* MOBILE NAVIGATION */

        .as-header-nav {
            position: fixed;

            top: 68px;
            left: 0;
            right: 0;

            width: 100%;

            height: auto;

            max-height: calc(100vh - 68px);

            overflow-y: auto;

            display: block;

            margin: 0;

            padding: 12px 18px 22px;

            background: #ffffff;

            border-top: 1px solid #eeeeee;

            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);

            opacity: 0;

            visibility: hidden;

            pointer-events: none;

            transform: translateY(-10px);

            transition:
                opacity 0.25s ease,
                transform 0.25s ease,
                visibility 0.25s ease;

            z-index: 100001;
        }


        /* OPEN MOBILE MENU */

        .as-header-menu-checkbox:checked ~ .as-header-nav {
            opacity: 1;

            visibility: visible;

            pointer-events: auto;

            transform: translateY(0);
        }


        /* MOBILE NAV LIST */

        .as-header-nav-list {
            width: 100%;

            height: auto;

            display: flex;

            flex-direction: column;

            align-items: stretch;

            gap: 0;

            margin: 0;

            padding: 0;
        }

        .as-header-nav-item {
            width: 100%;

            height: auto;

            display: block;
        }


        /* MOBILE LINKS */

        .as-header-nav-link {
            width: 100%;

            min-height: 50px;

            height: auto;

            display: flex;

            align-items: center;

            padding: 12px 8px;

            font-size: 15px;
        }

        .as-header-nav-link.as-header-active::after {
            display: none;
        }


        /* MOBILE FEATURES */

        .as-header-features {
            width: 100%;

            height: auto;

            display: block;
        }

        .as-header-features-summary {
            width: 100%;

            min-height: 50px;

            height: auto;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 12px 8px;

            font-size: 15px;
        }

        .as-header-features-dropdown {
            position: static;

            width: 100%;

            padding: 0 0 5px 12px;

            transform: none;

            background: #fafafa;

            border-radius: 8px;

            box-shadow: none;

            z-index: auto;
        }


        /* MOBILE DOWNLOAD */

        .as-header-download {
            width: 100%;

            height: 46px;

            margin-top: 10px;
        }


        /* MOBILE LOGIN */

        .as-header-login {
            width: 100%;

            height: 46px;

            margin-top: 10px;
        }
    }


    /* =========================================================
       SMALL PHONES
       ========================================================= */

    @media (max-width: 480px) {

        .as-main-header {
            padding: 0 15px;
        }

        .as-header-logo {
            gap: 8px;
        }

        .as-header-logo img {
            width: 38px;
            height: 38px;
        }

        .as-header-logo-name {
            font-size: 19px;
        }

        .as-header-nav {
            padding-left: 14px;
            padding-right: 14px;
        }
    }


    /* =========================================================
       VERY SMALL PHONES
       ========================================================= */

    @media (max-width: 360px) {

        .as-header-logo img {
            width: 36px;
            height: 36px;
        }

        .as-header-logo-name {
            font-size: 18px;
        }
    }

    /* Force logo image on every page */
header.as-main-header .as-header-logo img {
    display: block !important;
    width: 42px !important;
    height: 42px !important;
    visibility: visible !important;
    opacity: 1 !important;
}
</style> --}}


<header class="as-main-header">

    <!-- =====================================================
         LOGO
         ===================================================== -->

    <a href="{{ route('/') }}" class="as-header-logo" aria-label="AffirmSpace Home">

        <img src="{{ asset('images/welcomepage.png') }}" alt="AffirmSpace Logo">

        <span class="as-header-logo-name">
            AffirmSpace
        </span>

    </a>


    @if (!Auth::check())

        <!-- =================================================
             MOBILE MENU CHECKBOX
             This controls the menu without JavaScript.
             ================================================= -->

        <input type="checkbox" id="as-header-menu-checkbox" class="as-header-menu-checkbox">


        <!-- =================================================
             MOBILE HAMBURGER
             ================================================= -->

        <label for="as-header-menu-checkbox" class="as-header-hamburger" aria-label="Open navigation menu">

            <span class="as-header-hamburger-lines"></span>

        </label>


        <!-- =================================================
             NAVIGATION
             ================================================= -->

        <nav class="as-header-nav" aria-label="Main navigation">

            <ul class="as-header-nav-list">


                <!-- HOME -->

                <li class="as-header-nav-item">

                    <a href="{{ url('/') }}"
                        class="as-header-nav-link {{ request()->is('/') ? 'as-header-active' : '' }}">
                        Home
                    </a>

                </li>


                <!-- ABOUT US -->

                <li class="as-header-nav-item">

                    <a href="{{ route('aboutUs') }}"
                        class="as-header-nav-link {{ request()->routeIs('aboutUs') ? 'as-header-active' : '' }}">
                        About Us
                    </a>

                </li>


                <!-- COMMUNITY -->

                <li class="as-header-nav-item">

                    <a href="{{ route('community') }}"
                        class="as-header-nav-link {{ request()->routeIs('community') ? 'as-header-active' : '' }}">
                        Community
                    </a>

                </li>


                <!-- FEATURES -->

                <li class="as-header-nav-item">

                    <details class="as-header-features">

                        <summary class="as-header-features-summary">

                            <span>
                                Features
                            </span>

                            <span class="as-header-feature-arrow"></span>

                        </summary>


                        <div class="as-header-features-dropdown">


                            <!-- CHAT -->

                            <a href="{{ route('chat') }}" class="as-header-dropdown-link">

                                <span class="as-header-dropdown-icon">
                                    <i class="fa-regular fa-comments"></i>
                                </span>

                                <span>
                                    Chat
                                </span>

                            </a>


                            <!-- DATING -->

                            <a href="{{ route('chatAndDating') }}" class="as-header-dropdown-link">

                                <span class="as-header-dropdown-icon">
                                    <i class="fa-solid fa-heart"></i>
                                </span>

                                <span>
                                    Dating
                                </span>

                            </a>


                            <!-- COUNSELLING -->

                            <a href="{{ route('counselling') }}" class="as-header-dropdown-link">

                                <span class="as-header-dropdown-icon">
                                    <i class="fa-solid fa-users"></i>
                                </span>

                                <span>
                                    Counselling
                                </span>

                            </a>


                            <!-- EVENTS -->

                            <a href="{{ route('events') }}" class="as-header-dropdown-link">

                                <span class="as-header-dropdown-icon">
                                    <i class="fa-regular fa-calendar"></i>
                                </span>

                                <span>
                                    Events
                                </span>

                            </a>

                        </div>

                    </details>

                </li>


                <!-- BLOGS -->

                <li class="as-header-nav-item">

                    <a href="{{ route('blogs') }}"
                        class="as-header-nav-link {{ request()->routeIs('blogs') || request()->routeIs('blog.detail') ? 'as-header-active' : '' }}">
                        Blogs
                    </a>

                </li>


                <!-- CONTACT US -->

                <li class="as-header-nav-item">

                    <a href="{{ route('contactWithAdmin') }}"
                        class="as-header-nav-link {{ request()->routeIs('contactWithAdmin') ? 'as-header-active' : '' }}">
                        Contact Us
                    </a>

                </li>


                <!-- DOWNLOAD OUR APP -->

                <li class="as-header-nav-item">

                    <a href="{{ route('apps') }}" class="as-header-download">

                        <i class="fa-solid fa-download as-header-download-icon"></i>

                        <span>
                            Download Our App
                        </span>

                    </a>

                </li>


                <!-- LOGIN -->

                <li class="as-header-nav-item">

                    @if (Auth::check())
                        <a href="{{ route('feed') }}" class="as-header-login">
                            Go to Feed
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="as-header-login">
                            Login
                        </a>
                    @endif

                </li>


            </ul>

        </nav>

    @endif

</header>
