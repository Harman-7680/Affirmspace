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

        header {
            background: #ffffff;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #222;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .logo img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .nav-btn {
            padding: 10px 24px;
            border-radius: 30px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        /* ────────────────────────────────────────
                           SPLASH SCREEN & OTHER STYLES (unchanged)
                        ──────────────────────────────────────── */
        #splash-screen {
            position: fixed;
            inset: 0;
            background-color: #dafaf8ff;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            font-size: 2rem;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        #splash-screen img {
            width: 150px;
            margin-bottom: 20px;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0%,
            50%,
            100% {
                transform: scale(1);
            }

            25%,
            75% {
                transform: scale(1.3);
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
    </style>
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TT8733ZM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Splash screen -->
    <div id="splash-screen">
        <img src="images/welcomepage.png" alt="AffirmSpace">
    </div>

    {{-- Navbar --}}
    @include('layouts.seo_header')

    @yield('content')

    @include('layouts.seo_footer')

    @yield('script')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const splash = document.getElementById('splash-screen');
            if (!sessionStorage.getItem('flashShown')) {
                splash.style.display = 'flex';
                setTimeout(() => {
                    splash.style.opacity = '0';
                    setTimeout(() => {
                        splash.style.display = 'none';
                    }, 500);
                }, 1000);
                sessionStorage.setItem('flashShown', 'true');
            }
        });
    </script>
</body>

</html>
