<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy – AffirmSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif
        }

        body {
            background: linear-gradient(135deg, #ff512f, #dd2476);
            color: #fff;
            line-height: 1.6
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 80px 24px
        }

        .hero {
            text-align: center;
            margin-bottom: 90px
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800
        }

        .hero p {
            max-width: 760px;
            margin: 24px auto 0;
            font-size: 1.2rem;
            color: #ffe6ee
        }

        .glass {
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(14px);
            border-radius: 24px;
            padding: 48px;
            margin-bottom: 48px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .25)
        }

        .section-title {
            font-size: 2rem;
            margin-bottom: 16px;
            font-weight: 700
        }

        ul {
            padding-left: 20px
        }

        li {
            margin-bottom: 10px;
            color: #ffe1ec
        }

        footer {
            text-align: center;
            margin-top: 80px;
            font-size: .85rem;
            color: #ffd1e0
        }

        .top-header {
            position: fixed;
            top: 35px;
            left: 35px;
            z-index: 100;
        }

        .logo-link img {
            height: 88px;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .logo-link:hover img {
            transform: scale(1.08);
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <header class="top-header">
        <a href="{{ route('login') }}" class="logo-link">
            <img src="images/welcomepage.png" alt="AffirmSpace Logo">
        </a>
    </header>
    
    <div class="container">

        <section class="hero">
            <h1>Your Privacy Matters 🔐</h1>
            <p>
                AffirmSpace is built on trust, dignity, and respect.
                This policy explains how we protect your data and your identity.
            </p>
        </section>

        <section class="glass">
            <h2 class="section-title">Information We Collect</h2>
            <ul>
                <li>Name, email or phone number</li>
                <li>Gender identity, pronouns, profile bio & photos</li>
                <li>Posts, chats, and community interactions</li>
                <li>Counselling preferences & encrypted chats</li>
                <li>Payment confirmation via third-party gateways</li>
                <li>Device, IP address & cookies (website only)</li>
            </ul>
        </section>

        <section class="glass">
            <h2 class="section-title">How We Use Your Data</h2>
            <ul>
                <li>Account creation & authentication</li>
                <li>Personalized content & safer connections</li>
                <li>Counselling & support services</li>
                <li>Platform safety and moderation</li>
                <li>Legal & compliance requirements</li>
            </ul>
        </section>

        <section class="glass">
            <h2 class="section-title">Data Protection</h2>
            <p>
                We use encrypted servers, secure storage, and end-to-end encrypted chats.
                Sensitive identity information is shown publicly only if you choose.
            </p>
        </section>

        <section class="glass">
            <h2 class="section-title">Your Rights</h2>
            <ul>
                <li>View, edit or delete your data</li>
                <li>Download your information</li>
                <li>Withdraw consent anytime</li>
                <li>Delete your account permanently</li>
            </ul>
        </section>

        <section class="glass">
            <h2 class="section-title">Contact</h2>
            <p>Email: <strong>privacy@affirmspace.com</strong></p>
        </section>

        <footer>
            © 2025 AffirmSpace — Privacy with Pride 🌈
        </footer>

    </div>
</body>

</html>
