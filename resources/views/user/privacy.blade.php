@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
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

        .privacy-parallax {
            position: relative;
            padding: 120px 8%;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        /* IMAGE */

        .privacy-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            z-index: -2;
        }

        /* DARK OVERLAY */

        .privacy-parallax::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: -1;
        }

        /* TEXT */

        .privacy-content {
            max-width: 850px;
            margin: auto;
        }

        .privacy-content h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .privacy-content p {
            color: #f0f0f0;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        /* MOBILE FIX */

        @media(max-width:1024px) {

            .privacy-img {
                position: absolute;
                height: 100%;
            }

            .privacy-parallax {
                padding: 100px 8%;
            }

        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="privacy-parallax">

        <img src="images/coursel.png" class="privacy-img"
            alt="LGBTQ community celebrating pride with rainbow flags and joy">

        <div class="privacy-content">
            <h2>Your Privacy Matters 🔐</h2>

            <p>
                AffirmSpace is a global 18+ community and counselling platform built on trust,
                dignity, and respect. This Privacy Policy explains how we collect,
                use, store, and protect your information.
            </p>
        </div>

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
    </section>
@endsection
