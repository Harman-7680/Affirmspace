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

        section {
            padding: 80px 8%;
        }

        section h2 {
            font-size: 2.1rem;
            margin-bottom: 15px;
            text-align: center;
        }

        section p {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            color: #555;
        }

        .features {
            background: #ffffff;
        }

        .feature-grid {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: #f9fafb;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .feature-card h3 {
            margin-bottom: 12px;
            font-size: 1.1rem;
        }

        .feature-card ul {
            padding-left: 18px;
            color: #555;
        }

        .feature-card li {
            margin-bottom: 8px;
        }

        .feature-card p {
            text-align: left;
            color: #555;
            margin-bottom: 10px;
        }

        .disclaimer {
            margin-top: 35px;
            font-size: 0.85rem;
            text-align: center;
            color: #666;
        }

        .site-footer {
            background: #ffffff;
            padding: 35px 8%;
            border-top: 1px solid #eee;
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

        @media(max-width: 900px) {
            section {
                padding: 60px 6%;
            }
        }
    </style>
</head>

<body>

    <!-- Header (Same as Home Page) -->
    <header>
        <a href="/" class="logo">
            <img src="images/welcomepage.png" alt="AffirmSpace Logo">
            <span>AffirmSpace</span>
        </a>

        <a href="/register" class="nav-btn">Get Started</a>
    </header>

    <!-- Hero Section -->
    <section>
        <h2>Your Privacy Matters 🔐</h2>
        <p>
            AffirmSpace is a global 18+ community and counselling platform built on trust,
            dignity, and respect. This Privacy Policy explains how we collect,
            use, store, and protect your information.
        </p>
    </section>

    <!-- Privacy Content -->
    <section class="features">
        <div class="feature-grid">

            <div class="feature-card">
                <h3>1. Information We Collect</h3>
                <ul>
                    <li>Name, email address or phone number</li>
                    <li>Gender identity, pronouns, profile bio & photos</li>
                    <li>Posts, chats, counselling session data</li>
                    <li>Payment confirmations (processed via Razorpay)</li>
                    <li>Device information, IP address & usage data</li>
                    <li>Push notification tokens</li>
                    <li>Approximate location (via LocationIQ)</li>
                    <li>Analytics data (Google Analytics & Firebase Analytics)</li>
                </ul>
            </div>

            <div class="feature-card">
                <h3>2. Sensitive Data</h3>
                <p>
                    Certain profile information may reveal gender identity or sexual orientation.
                    Such information is processed strictly based on user consent.
                </p>
            </div>

            <div class="feature-card">
                <h3>3. How We Use Your Data</h3>
                <ul>
                    <li>Account creation & authentication</li>
                    <li>Providing counselling services</li>
                    <li>Processing payments securely</li>
                    <li>Improving platform experience</li>
                    <li>Sending push notifications</li>
                    <li>Maintaining safety and preventing abuse</li>
                    <li>Legal & compliance requirements</li>
                </ul>
                <p><strong>We do not sell or rent your personal data.</strong></p>
            </div>

            <div class="feature-card">
                <h3>4. Payments</h3>
                <p>
                    Payments are processed securely via Razorpay.
                    AffirmSpace does not store full card numbers or CVV codes.
                </p>
            </div>

            <div class="feature-card">
                <h3>5. Data Sharing</h3>
                <ul>
                    <li>Firebase</li>
                    <li>Google Analytics</li>
                    <li>LocationIQ</li>
                    <li>Razorpay</li>
                    <li>Jitsi</li>
                </ul>
            </div>

            <div class="feature-card">
                <h3>6. International Data Transfers</h3>
                <p>
                    Your data may be processed on servers located outside your country.
                    By using AffirmSpace, you consent to such transfers.
                </p>
            </div>

        </div>

        <p class="disclaimer">
            © 2026 AffirmSpace — Privacy with Pride 🌈
        </p>
    </section>

    <!-- Footer (Same as Home Page) -->
    <footer class="site-footer">
        <div class="footer-links">
            <a href="/aboutUs">About Us</a>
            <a href="/privacy">Privacy Policy</a>
            <a href="/refundPolicy">Refund</a>
            <a href="/terms">Terms & Conditions</a>
            <a href="/contactWithAdmin">Contact</a>
        </div>

        <p class="footer-copy">
            © 2026 AffirmSpace. All rights reserved.
        </p>
    </footer>

</body>

</html>