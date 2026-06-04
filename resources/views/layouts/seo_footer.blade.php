<footer class="site-footer">
    <div class="footer-inner">

        @if (!Auth::check())
            <div class="footer-links">

                <a href="{{ route('blogs') }}"
                    class="{{ request()->routeIs('blogs') ? 'activeTab font-bold text-blue-600' : '' }}">
                    Blogs
                </a>

                <a href="{{ route('privacy') }}"
                    class="{{ request()->routeIs('privacy') ? 'activeTab font-bold text-blue-600' : '' }}">
                    Privacy Policy
                </a>

                <a href="{{ route('refundPolicy') }}"
                    class="{{ request()->routeIs('refundPolicy') ? 'activeTab font-bold text-blue-600' : '' }}">
                    Refund
                </a>

                <a href="{{ route('terms') }}"
                    class="{{ request()->routeIs('terms') ? 'activeTab font-bold text-blue-600' : '' }}">
                    Terms & Conditions
                </a>

                <a href="{{ route('contactWithAdmin') }}"
                    class="{{ request()->routeIs('contactWithAdmin') ? 'activeTab font-bold text-blue-600' : '' }}">
                    Contact
                </a>

            </div>
        @endif

        <div class="footer-bottom">

            <p class="footer-copy">
                © {{ date('Y') }} AffirmSpace. All rights reserved.
            </p>

            <div class="footer-store-buttons">

                <!-- Google Play Button -->
                <a href="https://play.google.com/store/apps/details?id=com.affirmspace.app" target="_blank">
                    <img src="{{ asset('images/googlebadge.png') }}" alt="Get it on Google Play">
                </a>

                <!-- Apple App Store Button -->

                <a href="https://apps.apple.com/app/id123456789" target="_blank">
                    <img src="{{ asset('images/applebadge.svg') }}" alt="Download on the App Store">
                </a>


            </div>

        </div>

    </div>
</footer>

<style>
    .footer-bottom {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
        min-height: 70px;
    }

    .footer-copy {
        text-align: center;
        margin: 0;
    }

    .footer-store-buttons {
        position: absolute;
        right: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .footer-store-buttons img {
        width: 170px;
        max-width: 100%;
        transition: 0.3s ease;
    }

    .footer-store-buttons img:hover {
        transform: scale(1.05);
    }

    @media(max-width:768px) {

        .footer-bottom {
            flex-direction: column;
            gap: 15px;
        }

        .footer-store-buttons {
            position: static;
            justify-content: center;
            flex-wrap: wrap;
        }

        .footer-store-buttons img {
            width: 150px;
        }
    }
</style>
