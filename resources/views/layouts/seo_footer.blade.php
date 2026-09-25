{{-- =========================================================
     AFFIRMSPACE FOOTER
     FULL REPLACEMENT
========================================================= --}}

<footer class="as-new-footer">

    <div class="as-new-footer-container">

        {{-- =================================================
             FOOTER MAIN CONTENT
        ================================================== --}}

        <div class="as-new-footer-grid">


            {{-- =================================================
                 BRAND COLUMN
            ================================================== --}}

            <div class="as-new-footer-column as-new-footer-brand">

                <a href="{{ url('/') }}" class="as-new-footer-brand-link">

                    {{-- Official AffirmSpace Logo --}}
                    <img src="{{ asset('images/welcomepage.png') }}" alt="AffirmSpace Logo" class="as-new-footer-logo">


                    {{-- Brand Name + Tagline --}}
                    <div class="as-new-footer-brand-text">

                        <div class="as-new-footer-brand-name">
                            AffirmSpace
                        </div>

                        <div class="as-new-footer-tagline">
                            Community. Connection. Care.
                        </div>

                    </div>

                </a>


                {{-- Description --}}
                <p class="as-new-footer-description">
                    A safe and inclusive space for the LGBTQ+ community
                    to connect, chat, learn and grow.
                </p>


                {{-- Social Icons --}}
                <div class="as-new-footer-socials">

                    <a href="https://www.instagram.com/affirmspaceofficial/?hl=en"
                        class="as-new-footer-social as-new-footer-instagram" aria-label="AffirmSpace on Instagram"
                        target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>


                    <a href="https://x.com/affirm_space" class="as-new-footer-social as-new-footer-x"
                        aria-label="AffirmSpace on X" target="_blank">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>


                    <a href="https://www.facebook.com/Affirmspace/" class="as-new-footer-social as-new-footer-facebook"
                        aria-label="AffirmSpace on Facebook" target="_blank">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <a href="https://www.threads.com/@affirmspaceofficial?hl=en"
                        class="as-new-footer-social as-new-footer-threads" aria-label="AffirmSpace on Threads"
                        target="_blank">
                        <i class="fa-brands fa-threads"></i>
                    </a>


                    <a href="https://www.linkedin.com/in/affirm-space-6a2632400/"
                        class="as-new-footer-social as-new-footer-linkedin" aria-label="AffirmSpace on LinkedIn"
                        target="_blank">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>

                </div>

            </div>



            {{-- =================================================
                 SUPPORT COLUMN
            ================================================== --}}

            <div class="as-new-footer-column">

                <h3 class="as-new-footer-heading">
                    Support
                </h3>


                <div class="as-new-footer-links">

                    <a href="{{ route('blogs') }}">
                        Blogs
                    </a>

                    <a href="{{ route('account-deletion') }}">
                        Account Deletion
                    </a>

                    <a href="{{ route('report-a-problem') }}">
                        Report a Problem
                    </a>

                    <a href="{{ route('community-guidelines') }}">
                        Community Guidelines
                    </a>

                    <a href="{{ route('safety-tips') }}">
                        Safety Tips
                    </a>

                </div>

            </div>



            {{-- =================================================
                 LEGAL COLUMN
            ================================================== --}}

            <div class="as-new-footer-column">

                <h3 class="as-new-footer-heading">
                    Legal
                </h3>


                <div class="as-new-footer-links">

                    <a href="{{ route('privacy') }}">
                        Privacy Policy
                    </a>

                    <a href="{{ route('terms') }}">
                        Terms &amp; Conditions
                    </a>

                    <a href="{{ route('refundPolicy') }}">
                        Refund Policy
                    </a>

                </div>

            </div>



            {{-- =================================================
                 STAY IN THE LOOP
            ================================================== --}}

            <div class="as-new-footer-column as-new-footer-loop">

                <h3 class="as-new-footer-heading">
                    Stay in the Loop
                </h3>


                <p class="as-new-footer-loop-text">
                    Get updates on new features, community stories
                    and more.
                </p>

                @if (session('success') || session('error'))
                    @php
                        $isSuccess = session('success');
                        $message = session('success') ?? session('error');
                    @endphp

                    <div class="custom-alert-overlay" id="customAlert">

                        <div class="custom-alert-box">

                            <div class="custom-alert-icon {{ $isSuccess ? 'success' : 'error' }}">
                                @if ($isSuccess)
                                    <i class="fa-solid fa-check"></i>
                                @else
                                    <i class="fa-solid fa-xmark"></i>
                                @endif
                            </div>

                            <div class="custom-alert-title">
                                {{ $isSuccess ? 'Thank You for Contacting Us!' : 'Something Went Wrong!' }}
                            </div>

                            <div class="custom-alert-message">
                                {{ $message }}
                            </div>

                            <button type="button" class="custom-alert-button {{ $isSuccess ? 'success' : 'error' }}"
                                onclick="closeCustomAlert()">
                                Done
                            </button>

                        </div>
                    </div>
                @endif

                {{-- Newsletter visual field --}}
                <form method="POST" action="{{ route('newsletter.subscribe') }}" class="as-new-footer-subscribe">
                    @csrf

                    <input type="email" name="email" placeholder="Your email address"
                        aria-label="Your email address" required>

                    <button type="submit" aria-label="Subscribe">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>


                <div class="as-new-footer-privacy">

                    <i class="fa-solid fa-lock"></i>

                    <span>
                        We respect your privacy.
                    </span>

                </div>

            </div>

        </div>



        {{-- =================================================
             FOOTER BOTTOM
        ================================================== --}}

        <div class="as-new-footer-bottom">

            <p class="as-new-footer-copyright">
                © {{ date('Y') }} AffirmSpace. All rights reserved.
            </p>


            <p class="as-new-footer-made">

                Made with

                <span class="as-new-footer-heart">
                    ♥
                </span>

                for a more inclusive world.

            </p>

        </div>

    </div>

</footer>

<style>
    .custom-alert-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.38);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999999;
        padding: 20px;
    }

    .custom-alert-box {
        width: 100%;
        max-width: 490px;
        background: #fff;
        border-radius: 16px;
        padding: 34px 36px 26px;
        text-align: center;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.22);
        animation: alertPopup 0.25s ease;
    }

    @keyframes alertPopup {
        from {
            opacity: 0;
            transform: scale(0.92);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .custom-alert-icon {
        width: 86px;
        height: 86px;
        border-radius: 50%;
        margin: 0 auto 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
    }

    .custom-alert-icon.success {
        color: #20c98b;
        background: #e8faf3;
        box-shadow: 0 0 0 12px #f2fcf8;
    }

    .custom-alert-icon.error {
        color: #ef4444;
        background: #fff0f0;
        box-shadow: 0 0 0 12px #fff7f7;
    }

    .custom-alert-title {
        font-size: 27px;
        font-weight: 700;
        color: #172033;
        margin-bottom: 10px;
    }

    .custom-alert-message {
        font-size: 17px;
        line-height: 1.55;
        color: #6b7280;
        margin-bottom: 24px;
    }

    .custom-alert-button {
        width: 100%;
        border: none;
        border-radius: 10px;
        padding: 14px 20px;
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .custom-alert-button.success {
        background: linear-gradient(90deg, #ff4b2b, #e91e63);
    }

    .custom-alert-button.error {
        background: linear-gradient(90deg, #ef4444, #dc2626);
    }

    .custom-alert-button:hover {
        opacity: 0.92;
        transform: translateY(-1px);
    }

    @media (max-width: 600px) {
        .custom-alert-box {
            padding: 30px 22px 22px;
        }

        .custom-alert-title {
            font-size: 23px;
        }

        .custom-alert-message {
            font-size: 15px;
        }
    }
</style>

<style>
    .as-new-footer {
        width: 100%;
        margin: 0;
        padding: 0;

        background: #ffffff;

        border-top: 1px solid #eeeeee;

        color: #333333;

        font-family: 'Inter', Arial, sans-serif;

        position: relative;
        z-index: 10;
    }


    .as-new-footer *,
    .as-new-footer *::before,
    .as-new-footer *::after {
        box-sizing: border-box;
    }


    .as-new-footer-container {
        width: 100%;
        max-width: 1080px;

        margin: 0 auto;

        padding: 60px 0 0;
    }



    /* =====================================================
       MAIN GRID
    ====================================================== */

    .as-new-footer-grid {
        width: 100%;

        display: grid;

        grid-template-columns:
            1.55fr 0.9fr 0.9fr 1.35fr;

        align-items: stretch;
    }



    /* =====================================================
       COLUMNS
    ====================================================== */

    .as-new-footer-column {
        min-width: 0;

        padding: 0 35px;
    }


    .as-new-footer-column:first-child {
        padding-left: 0;
    }


    .as-new-footer-column:last-child {
        padding-right: 0;
    }


    /* Vertical separator */

    .as-new-footer-column+.as-new-footer-column {
        border-left: 1px solid #eeeeee;
    }



    /* =====================================================
       BRAND AREA
    ====================================================== */

    .as-new-footer-brand-link {
        display: flex;

        align-items: center;

        gap: 14px;

        width: fit-content;

        margin: 0;

        padding: 0;

        text-decoration: none !important;

        border: 0;
        outline: none;
    }


    /* Official logo */

    .as-new-footer-logo {
        display: block;

        width: 65px;
        height: 65px;

        flex: 0 0 65px;

        object-fit: contain;
    }



    /* =====================================================
       BRAND TEXT
    ====================================================== */

    .as-new-footer-brand-text {
        display: flex;

        flex-direction: column;

        justify-content: center;

        min-width: 0;
    }


    .as-new-footer-brand-name {
        margin: 0;

        padding: 0;

        color: #222222;

        font-size: 24px;

        line-height: 1.15;

        font-weight: 800;

        letter-spacing: -0.5px;
    }


    .as-new-footer-tagline {
        margin: 6px 0 0;

        padding: 0;

        color: #222222;

        font-size: 14px;

        line-height: 1.4;

        font-weight: 700;

        white-space: nowrap;
    }



    /* =====================================================
       DESCRIPTION
    ====================================================== */

    .as-new-footer-description {
        max-width: 330px;

        margin: 20px 0 0;

        padding: 0;

        color: #667085;

        font-size: 14px;

        line-height: 1.7;

        font-weight: 400;

        text-align: left;
    }



    /* =====================================================
       SOCIAL ICONS
    ====================================================== */

    .as-new-footer-socials {
        display: flex;

        align-items: center;

        gap: 12px;

        margin-top: 25px;

        padding: 0;
    }


    .as-new-footer-social {
        width: 34px;
        height: 34px;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        border-radius: 50%;

        color: #ffffff !important;

        text-decoration: none !important;

        font-size: 14px;

        line-height: 1;

        transition:
            transform 0.25s ease,
            opacity 0.25s ease;
    }


    .as-new-footer-social:hover {
        color: #ffffff !important;

        transform: translateY(-3px);

        opacity: 0.88;
    }


    .as-new-footer-instagram {
        background: linear-gradient(135deg,
                #feda75,
                #fa7e1e,
                #d62976,
                #962fbf,
                #4f5bd5);
    }


    .as-new-footer-x {
        background: #000000;
    }


    .as-new-footer-facebook {
        background: #1877f2;
    }


    .as-new-footer-threads {
        background: #000000;
    }

    .as-new-footer-linkedin {
        background: #0a66c2;
    }



    /* =====================================================
       COLUMN HEADINGS
    ====================================================== */

    .as-new-footer-heading {
        margin: 2px 0 22px;

        padding: 0;

        color: #222222;

        font-size: 15px;

        line-height: 1.4;

        font-weight: 800;

        text-align: left;
    }



    /* =====================================================
       LINKS
    ====================================================== */

    .as-new-footer-links {
        display: flex;

        flex-direction: column;

        align-items: flex-start;

        gap: 13px;
    }


    .as-new-footer-links a {
        display: inline-block;

        margin: 0;
        padding: 0;

        color: #667085 !important;

        font-size: 13px;

        line-height: 1.5;

        font-weight: 400;

        text-decoration: none !important;

        transition:
            color 0.2s ease,
            transform 0.2s ease;
    }


    .as-new-footer-links a:hover {
        color: #dd2476 !important;

        transform: translateX(3px);
    }



    /* =====================================================
       STAY IN LOOP
    ====================================================== */

    .as-new-footer-loop-text {
        max-width: 290px;

        margin: 0 0 19px;

        padding: 0;

        color: #667085;

        font-size: 13px;

        line-height: 1.7;

        text-align: left;
    }



    /* =====================================================
       EMAIL SUBSCRIBE BOX
    ====================================================== */

    .as-new-footer-subscribe {
        width: 100%;
        max-width: 280px;

        height: 50px;

        display: flex;

        align-items: center;

        padding: 4px 4px 4px 15px;

        background: #ffffff;

        border: 1px solid #e2e2e2;

        border-radius: 999px;

        box-shadow:
            0 4px 15px rgba(0, 0, 0, 0.04);

        transition:
            border-color 0.25s ease,
            box-shadow 0.25s ease;
    }


    .as-new-footer-subscribe:focus-within {
        border-color: #dd2476;

        box-shadow:
            0 5px 20px rgba(221, 36, 118, 0.10);
    }


    .as-new-footer-subscribe input {
        flex: 1;

        width: 100%;
        min-width: 0;

        height: 40px;

        margin: 0;
        padding: 0 8px 0 0;

        border: 0 !important;

        outline: none !important;

        background: transparent !important;

        color: #333333;

        font-family: inherit;

        font-size: 12px;
    }


    .as-new-footer-subscribe input::placeholder {
        color: #98a2b3;

        opacity: 1;
    }


    .as-new-footer-subscribe button {
        width: 40px;
        height: 40px;

        flex: 0 0 40px;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        margin: 0;
        padding: 0;

        border: 0;

        border-radius: 50%;

        background:
            linear-gradient(90deg,
                #ff512f,
                #dd2476);

        color: #ffffff;

        font-size: 13px;

        cursor: pointer;

        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease;
    }


    .as-new-footer-subscribe button:hover {
        transform: scale(1.06);

        box-shadow:
            0 5px 15px rgba(221, 36, 118, 0.25);
    }



    /* =====================================================
       PRIVACY NOTE
    ====================================================== */

    .as-new-footer-privacy {
        display: flex;

        align-items: center;

        gap: 6px;

        margin-top: 12px;

        color: #98a2b3;

        font-size: 11px;

        line-height: 1.5;
    }


    .as-new-footer-privacy i {
        color: #667085;

        font-size: 10px;
    }



    /* =====================================================
       BOTTOM BAR
    ====================================================== */

    .as-new-footer-bottom {
        width: 100%;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        margin-top: 50px;

        padding: 20px 0 24px;

        border-top: 1px solid #eeeeee;
    }


    .as-new-footer-bottom p {
        margin: 0;

        padding: 0;

        color: #98a2b3;

        font-size: 12px;

        line-height: 1.5;

        font-weight: 400;
    }


    .as-new-footer-heart {
        color: #dd2476;

        font-size: 14px;

        padding: 0 2px;
    }



    /* =====================================================
       TABLET
    ====================================================== */

    @media (max-width: 1050px) {

        .as-new-footer-container {
            padding-left: 30px;
            padding-right: 30px;
        }


        .as-new-footer-column {
            padding-left: 25px;
            padding-right: 25px;
        }


        .as-new-footer-logo {
            width: 65px;
            height: 65px;

            flex-basis: 65px;
        }


        .as-new-footer-brand-name {
            font-size: 22px;
        }


        .as-new-footer-tagline {
            font-size: 13px;
        }

    }



    /* =====================================================
       SMALL TABLET
    ====================================================== */

    @media (max-width: 850px) {

        .as-new-footer-container {
            padding-top: 50px;
        }


        .as-new-footer-grid {
            grid-template-columns:
                1.2fr 1fr 1fr;
        }


        .as-new-footer-brand {
            grid-column: 1 / -1;

            padding-left: 0;
            padding-right: 0;

            padding-bottom: 35px;
        }


        .as-new-footer-brand+.as-new-footer-column {
            border-left: 0;
        }


        .as-new-footer-column:nth-child(3),
        .as-new-footer-column:nth-child(4) {
            border-left: 1px solid #eeeeee;
        }

    }



    /* =====================================================
       MOBILE
    ====================================================== */

    @media (max-width: 650px) {

        .as-new-footer-container {
            padding:
                45px 22px 0;
        }


        .as-new-footer-grid {
            display: flex;

            flex-direction: column;

            width: 100%;
        }


        .as-new-footer-column,
        .as-new-footer-column:first-child,
        .as-new-footer-column:last-child {
            width: 100%;

            padding:
                28px 0;

            border-left: 0 !important;

            border-top: 1px solid #eeeeee;
        }


        .as-new-footer-brand {
            padding-top: 0;

            padding-bottom: 30px;

            border-top: 0 !important;
        }


        .as-new-footer-brand-link {
            gap: 12px;
        }


        .as-new-footer-logo {
            width: 65px;
            height: 65px;

            flex-basis: 65px;
        }


        .as-new-footer-brand-name {
            font-size: 22px;
        }


        .as-new-footer-tagline {
            font-size: 12px;

            margin-top: 5px;
        }


        .as-new-footer-description {
            max-width: 100%;

            margin-top: 18px;
        }


        .as-new-footer-socials {
            margin-top: 22px;
        }


        .as-new-footer-loop {
            padding-bottom: 35px;
        }


        .as-new-footer-subscribe {
            max-width: 100%;
        }


        .as-new-footer-bottom {
            flex-direction: column;

            align-items: flex-start;

            gap: 7px;

            margin-top: 0;

            padding:
                20px 0 25px;
        }

    }



    /* =====================================================
       SMALL MOBILE
    ====================================================== */

    @media (max-width: 400px) {

        .as-new-footer-container {
            padding-left: 18px;
            padding-right: 18px;
        }


        .as-new-footer-logo {
            width: 60px;
            height: 60px;

            flex-basis: 60px;
        }


        .as-new-footer-brand-name {
            font-size: 20px;
        }


        .as-new-footer-tagline {
            font-size: 11px;
        }


        .as-new-footer-description {
            font-size: 13px;
        }


        .as-new-footer-socials {
            gap: 9px;
        }


        .as-new-footer-social {
            width: 33px;
            height: 33px;

            font-size: 13px;
        }


        .as-new-footer-heading {
            font-size: 15px;
        }


        .as-new-footer-links a,
        .as-new-footer-loop-text {
            font-size: 13px;
        }

    }
</style>

<script>
    function closeCustomAlert(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        document.querySelectorAll('.custom-alert-overlay').forEach(function(popup) {
            popup.remove();
        });
    }
</script>
