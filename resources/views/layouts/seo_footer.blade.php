<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-links">
            <a href="{{ '/aboutUs' }}"
                class="{{ request()->routeIs('aboutUs') ? 'activeTab font-bold text-blue-600' : '' }}">About Us</a>

            <a href="{{ '/privacy' }}"
                class="{{ request()->routeIs('privacy') ? 'activeTab font-bold text-blue-600' : '' }}">Privacy Policy</a>

            <a href="{{ '/refundPolicy' }}"
                class="{{ request()->routeIs('refundPolicy') ? 'activeTab font-bold text-blue-600' : '' }}">Refund</a>

            <a href="{{ '/terms' }}"
                class="{{ request()->routeIs('terms') ? 'activeTab font-bold text-blue-600' : '' }}">Terms &
                Conditions</a>

            <a href="{{ '/contactWithAdmin' }}"
                class="{{ request()->routeIs('contactWithAdmin') ? 'activeTab font-bold text-blue-600' : '' }}">Contact</a>
        </div>

        <p class="footer-copy">
            © 2026 AffirmSpace. All rights reserved.
        </p>
    </div>
</footer>
