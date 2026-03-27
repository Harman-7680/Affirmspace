@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        section {
            padding: 80px 8%;
        }

        /* HERO */

        .terms-hero {
            position: relative;
            padding: 120px 8%;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .terms-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            z-index: -2;
        }

        .terms-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .terms-content {
            max-width: 800px;
            margin: auto;
        }

        .terms-content h1 {
            font-size: 2.4rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .terms-content p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #eee;
        }

        /* CONTENT */

        .terms-section {
            background: #ffffff;
        }

        .terms-header {
            text-align: center;
            max-width: 750px;
            margin: 0 auto 40px;
        }

        .terms-header h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .terms-header p {
            color: #666;
        }

        /* GRID */

        .terms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        /* CARD */

        .terms-card {
            background: #f9fafb;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            transition: 0.2s ease;
        }

        .terms-card:hover {
            transform: translateY(-3px);
        }

        .terms-card h3 {
            font-size: 1.15rem;
            margin-bottom: 12px;
            color: #111;
        }

        .terms-card p {
            color: #555;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .terms-card ul {
            padding-left: 18px;
            color: #555;
        }

        .terms-card li {
            margin-bottom: 8px;
        }

        .terms-footer {
            text-align: center;
            margin-top: 50px;
            font-size: 0.9rem;
            color: #777;
        }

        @media(max-width:1024px) {
            .terms-img {
                position: absolute;
                height: 100%;
            }

            .terms-hero {
                padding: 100px 8%;
            }

            .terms-content h1 {
                font-size: 2rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- HERO -->
    <section class="terms-hero">

        <img src="{{ asset('images/coursel.png') }}" class="terms-img" alt="Terms background">

        <div class="terms-content">
            <h1>Terms & Conditions 📜</h1>
            <p>
                Please read these terms carefully before using AffirmSpace. By using our platform, you agree to follow these
                rules and guidelines.
            </p>
        </div>

    </section>

    <!-- CONTENT -->
    <section class="terms-section">

        <div class="terms-header">
            <h2>Legal Terms & Platform Rules</h2>
            <p>
                These terms define your rights, responsibilities, and acceptable use of AffirmSpace.
            </p>
        </div>

        <div class="terms-grid">

            <div class="terms-card">
                <h3>1. Eligibility (18+ Only)</h3>
                <p>
                    AffirmSpace is strictly for users aged 18 or older.
                </p>
                <p>
                    By using this platform, you confirm that you meet this requirement.
                </p>
                <p>
                    Accounts found to be underage will be removed without notice.
                </p>
            </div>

            <div class="terms-card">
                <h3>2. User Accounts</h3>
                <p>
                    You are responsible for maintaining the confidentiality of your account credentials.
                </p>
                <p>
                    All activity under your account is your responsibility.
                </p>
            </div>

            <div class="terms-card">
                <h3>3. Community Guidelines</h3>
                <ul>
                    <li>No harassment, abuse, or hate speech</li>
                    <li>No discrimination based on identity</li>
                    <li>No illegal or harmful content</li>
                    <li>No impersonation or fraud</li>
                </ul>
            </div>

            <div class="terms-card">
                <h3>4. Counselling Disclaimer</h3>
                <p>
                    Counselling services are supportive in nature and do not guarantee outcomes.
                </p>
                <p>
                    AffirmSpace is not a substitute for medical or psychiatric treatment.
                </p>
                <p>
                    This platform is not for emergency situations.
                </p>
            </div>

            <div class="terms-card">
                <h3>5. Payments</h3>
                <p>
                    Paid services must be completed through approved payment methods.
                </p>
                <p>
                    By making a payment, you agree to pricing and billing terms.
                </p>
            </div>

            <div class="terms-card">
                <h3>6. Refund Policy</h3>
                <p>
                    Refunds are handled according to our official refund policy.
                </p>
                <p>
                    <a href="/refund-policy">View Refund Policy</a>
                </p>
            </div>

            <div class="terms-card">
                <h3>7. User Content</h3>
                <p>
                    You are responsible for all content you post on the platform.
                </p>
                <p>
                    AffirmSpace may remove content that violates guidelines.
                </p>
            </div>

            <div class="terms-card">
                <h3>8. Account Suspension</h3>
                <p>
                    We reserve the right to suspend or terminate accounts for violations or misuse.
                </p>
                <p>
                    No refunds will be issued in such cases.
                </p>
            </div>

            <div class="terms-card">
                <h3>9. Privacy</h3>
                <p>
                    Your data is handled according to our Privacy Policy.
                </p>
                <p>
                    <a href="/privacy-policy">View Privacy Policy</a>
                </p>
            </div>

            <div class="terms-card">
                <h3>10. Limitation of Liability</h3>
                <p>
                    AffirmSpace is not responsible for user interactions, disputes, or service outcomes.
                </p>
            </div>

            <div class="terms-card">
                <h3>11. Governing Law</h3>
                <p>
                    These terms are governed by the laws of India.
                </p>
            </div>

            <div class="terms-card">
                <h3>Contact</h3>
                <p>Email: <strong>affirmspace@gmail.com</strong></p>
            </div>

        </div>

        <div class="terms-footer">
            © 2026 AffirmSpace — Safe Space. Clear Rules. 🌈
        </div>

    </section>
@endsection
