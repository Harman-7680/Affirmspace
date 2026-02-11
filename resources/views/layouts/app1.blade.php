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

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">

    <!-- title and description-->
    <title>@yield('title', 'AffirmSpace')</title>
    <meta name="description" content="Socialite - Social sharing network HTML Template">

    @yield('syntax-highlighter')

    <!-- css files -->
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @yield('css')
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TT8733ZM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="wrapper">

        {{-- Navbar --}}
        @include('layouts.navbar')

        @if (Auth::check())
            @if (Auth::user()->role == 0)
                {{-- Normal User Sidebar --}}
                @include('layouts.sidebar')
            @elseif (Auth::user()->role == 1)
                {{-- Counselor Message Bar --}}
                @include('counselor.sidebar')
            @endif
        @endif

        <!-- Loader -->
        <div id="loader" class="fixed inset-0 bg-white z-[99999] flex flex-col items-center justify-center">

            <!-- Heart Spinner -->
            <div class="relative w-20 h-20">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-12 h-12 text-red-500 animate-heartbeat" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                    2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09
                    C13.09 3.81 14.76 3 16.5 3
                    19.58 3 22 5.42 22 8.5
                    c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main App Content -->
        <div id="app-content" class="hidden">
            @yield('content')
        </div>

        <!-- Tailwind Custom Animations -->
        <style>
            @keyframes heartbeat {

                0%,
                100% {
                    transform: scale(1) rotate(0deg);
                }

                25% {
                    transform: scale(1.2) rotate(15deg);
                }

                50% {
                    transform: scale(1) rotate(0deg);
                }

                75% {
                    transform: scale(1.2) rotate(-15deg);
                }
            }

            .animate-heartbeat {
                animation: heartbeat 1s infinite ease-in-out;
            }
        </style>

        <!-- Loader Script -->
        {{-- <script>
            window.addEventListener("load", function() {
                setTimeout(() => {
                    document.getElementById("loader").style.opacity = "0";
                    setTimeout(() => {
                        document.getElementById("loader").style.display = "none";
                        document.getElementById("app-content").classList.remove("hidden");
                    }, 500);
                }, 800);
            });

            window.addEventListener("beforeunload", function() {
                document.getElementById("loader").style.display = "flex";
                document.getElementById("app-content").classList.add("hidden");
            });
        </script> --}}

        <script>
            // Show loader on navigation
            window.addEventListener("pagehide", () => {
                const loader = document.getElementById("loader");
                const app = document.getElementById("app-content");

                if (loader) {
                    loader.style.display = "flex";
                    loader.style.opacity = "1";
                }
                if (app) app.classList.add("hidden");
            });

            // Fast fade-out loader
            document.addEventListener("DOMContentLoaded", () => {
                const loader = document.getElementById("loader");
                const heart = loader.querySelector("svg");
                const app = document.getElementById("app-content");

                // Fast transition time
                loader.style.transition = "opacity 0.35s ease";
                heart.style.transition = "opacity 0.35s ease";

                // Start fade immediately
                setTimeout(() => {
                    heart.style.opacity = "0";
                    loader.style.opacity = "0";

                    // Remove loader after fade
                    setTimeout(() => {
                        loader.style.display = "none";
                        app.classList.remove("hidden");
                    }, 350);
                }, 80); // minimal delay for layout to render
            });
        </script>

        {{-- <script>
            window.addEventListener("pageshow", function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        </script> --}}

        {{-- @yield('content') --}}

        {{-- <script type="module" src="{{ asset('js/globalCall.js') }}"></script> --}}
        <!-- Javascript -->
        <script src="{{ asset('js/uikit.min.js') }}"></script>
        <script src="{{ asset('js/simplebar.js') }}"></script>
        {{-- <script src="{{ asset('js/script.js') }}"></script> --}}
        <script type="module" src="/js/script.js"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        <!-- Ion icon -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        @yield('script')
</body>

</html>
