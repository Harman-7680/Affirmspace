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

    <meta charset="UTF-8" />
    <title>AffirmSpace – LGBTQ+ Dating, Events & Gender-Affirming Healthcare</title>

    <meta name="description"
        content="AffirmSpace is a safe LGBTQ+ platform for dating, community, anonymous chats, local events, and discovering trusted gender-affirming healthcare providers." />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

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

        /* NAVBAR */
        header {
            background: #ffffff;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        /* HERO */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
            padding: 90px 8%;
        }

        .hero-text {
            max-width: 580px;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 35px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .primary-btn {
            padding: 14px 34px;
            border-radius: 30px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .secondary-btn {
            padding: 14px 34px;
            border-radius: 30px;
            text-decoration: none;
            border: 2px solid #dd2476;
            color: #dd2476;
            font-weight: 600;
        }

        .hero-image img {
            width: 430px;
            max-width: 100%;
        }

        /* SECTION */
        section {
            padding: 80px 8%;
        }

        section h2 {
            font-size: 2.1rem;
            margin-bottom: 15px;
            text-align: center;
        }

        section p {
            max-width: 850px;
            margin: 0 auto;
            text-align: center;
            color: #555;
        }

        /* FEATURES */
        .features {
            background: #ffffff;
        }

        .feature-grid {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: #f9fafb;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .feature-card h3 {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .disclaimer {
            margin-top: 35px;
            font-size: 0.85rem;
            text-align: center;
            color: #666;
        }

        /* IDENTITY */
        .identity {
            background: #ffffff;
            text-align: center;
        }

        .identity-points {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            font-weight: 500;
        }

        /* TRUST */
        .trust {
            background: #f9fafb;
            text-align: center;
        }

        .trust ul {
            list-style: none;
            margin-top: 25px;
        }

        .trust li {
            margin: 10px 0;
            font-weight: 500;
        }

        /* CTA */
        .cta {
            text-align: center;
            background: #ffffff;
        }

        .cta p {
            margin-bottom: 30px;
        }

        /* FOOTER */
        footer {
            padding: 25px;
            text-align: center;
            font-size: 0.9rem;
            color: #777;
        }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Splash screen overlay */
        #splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #dafaf8ff;
            display: none;
            /* FIX */
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            font-size: 2rem;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }


        /* Heart pulse animation */
        #splash-screen img {
            width: 150px;
            margin-bottom: 20px;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.3);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
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

    <header>
        <a href="/" class="logo">
            <img src="images/welcomepage.png" alt="AffirmSpace Logo">
            <span>AffirmSpace</span>
        </a>

        <a href="{{ 'register' }}" class="nav-btn">Get Started</a>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1>A Safe LGBTQ+ Platform for Dating, Events & Gender-Affirming Healthcare</h1>
            <p>
                AffirmSpace is your all-in-one LGBTQ+ space to connect, date, join anonymous
                chat groups, explore local events, and discover trusted gender-affirming
                healthcare providers — safely and respectfully.
            </p>

            <div class="hero-buttons">
                <a href="{{ 'register' }}" class="primary-btn">Create an Account</a>
                <a href="{{ 'login' }}" class="secondary-btn">Already have a Account</a>
            </div>
        </div>

        <div class="hero-image">
            <img src="images/background.png"
                alt="Inclusive LGBTQ+ community, dating, events and healthcare illustration">
        </div>
    </section>

    <section>
        <h2>What is AffirmSpace?</h2>
        <p>
            AffirmSpace is an LGBTQ+ social, dating, and wellbeing platform designed to
            support people through connection, self-expression, gender transition,
            healthcare discovery, and real-world community experiences.
        </p>
    </section>

    <section class="features">
        <h2>Everything You Need, In One Safe Space</h2>

        <div class="feature-grid">
            <div class="feature-card">
                <h3>💖 LGBTQ+ Dating</h3>
                <p>Build meaningful, respectful relationships without fear or judgment.</p>
            </div>

            <div class="feature-card">
                <h3>🌈 Community & Social Sharing</h3>
                <p>Share your story and connect with people who truly understand you.</p>
            </div>

            <div class="feature-card">
                <h3>👥 Anonymous Chat Groups</h3>
                <p>Talk freely, ask questions, and find support while staying anonymous.</p>
            </div>

            <div class="feature-card">
                <h3>📍 LGBTQ+ Events Near You</h3>
                <p>Explore pride events, meetups, workshops, and safe queer spaces nearby.</p>
            </div>

            <div class="feature-card">
                <h3>🧠 Mental & Emotional Wellbeing</h3>
                <p>Access LGBTQ+ friendly counselors and emotional support resources.</p>
            </div>

            <div class="feature-card">
                <h3>🧬 Hormone Therapy Discovery</h3>
                <p>Find verified hormone therapy and endocrinology providers.</p>
            </div>

            <div class="feature-card">
                <h3>🩺 Transition-Experienced Doctors</h3>
                <p>Discover doctors experienced in gender-affirming care.</p>
            </div>

            <div class="feature-card">
                <h3>✨ Gender-Affirming Surgeries</h3>
                <p>Explore trusted surgeons for facial and gender-affirming procedures.</p>
            </div>
        </div>

        <p class="disclaimer">
            AffirmSpace does not provide medical advice. We help users discover verified
            professionals and trusted resources.
        </p>
    </section>

    <section class="identity">
        <h2>Be Yourself — On Your Terms</h2>
        <p>
            Whether you choose to be visible or anonymous, AffirmSpace gives you complete
            control over your identity and privacy.
        </p>

        <div class="identity-points">
            <div>✔ Optional anonymity</div>
            <div>✔ Pronoun & identity controls</div>
            <div>✔ No forced labels</div>
            <div>✔ Zero tolerance for harassment</div>
        </div>
    </section>

    <section class="trust">
        <h2>Built on Safety, Privacy & Trust</h2>
        <ul>
            <li>✔ Moderated LGBTQ+ inclusive community</li>
            <li>✔ Privacy-first design</li>
            <li>✔ Verified healthcare discovery</li>
            <li>✔ Respect, consent & dignity</li>
        </ul>
    </section>

    <section class="cta">
        <h2>You Belong Here</h2>
        <p>
            Whether you want to date, connect, transition, attend events, or simply be
            yourself — AffirmSpace is here for you.
        </p>

        <a href="{{ 'register' }}" class="primary-btn">Continue to AffirmSpace</a>
    </section>

    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-links">
                <a href="{{ '/aboutUs' }}">About Us</a>
                <a href="{{ '/privacy' }}">Privacy Policy</a>
                <a href="{{ '/refundPolicy' }}">Refund</a>
                <a href="{{ '/terms' }}">Terms & Conditions</a>
                <a href="{{ '/contactWithAdmin' }}">Contact</a>
            </div>

            <p class="footer-copy">
                © 2026 AffirmSpace. All rights reserved.
            </p>
        </div>
    </footer>

</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const splash = document.getElementById('splash-screen');

        if (!sessionStorage.getItem('flashShown')) {
            splash.style.display = 'flex'; // show splash

            setTimeout(() => {
                splash.style.opacity = '0';

                setTimeout(() => {
                    splash.style.display = 'none';
                }, 500);
            }, 1000); // splash duration

            sessionStorage.setItem('flashShown', 'true');
        }
    });
</script>

</html>
