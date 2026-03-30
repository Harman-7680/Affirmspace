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

        <p class="footer-copy">
            © {{ date('Y') }} AffirmSpace. All rights reserved.
        </p>
    </div>
</footer>
