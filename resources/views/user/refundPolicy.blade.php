@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Policy – AffirmSpace</title>

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

        /* HERO SECTION */

        .refund-hero {
            position: relative;
            padding: 120px 8%;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .refund-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            z-index: -2;
        }

        .refund-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .refund-content {
            max-width: 800px;
            margin: auto;
        }

        .refund-content h1 {
            font-size: 2.4rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .refund-content p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #eee;
        }

        /* CONTENT SECTION */

        .policy-section {
            background: #ffffff;
        }

        .policy-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 40px;
        }

        .policy-header h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .policy-header p {
            color: #666;
        }

        /* GRID */

        .policy-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        /* CARD */

        .policy-card {
            background: #f9fafb;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            transition: 0.2s ease;
        }

        .policy-card:hover {
            transform: translateY(-3px);
        }

        .policy-card h3 {
            font-size: 1.15rem;
            margin-bottom: 12px;
            color: #111;
        }

        .policy-card p {
            color: #555;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .policy-card ul {
            padding-left: 18px;
            color: #555;
        }

        .policy-card li {
            margin-bottom: 8px;
        }

        /* FOOTER NOTE */

        .policy-footer {
            text-align: center;
            margin-top: 50px;
            font-size: 0.9rem;
            color: #777;
        }

        /* MOBILE */

        @media(max-width:1024px) {
            .refund-img {
                position: absolute;
                height: 100%;
            }

            .refund-hero {
                padding: 100px 8%;
            }

            .refund-content h1 {
                font-size: 2rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- HERO -->
    <section class="refund-hero">

        <img src="{{ asset('images/coursel.png') }}" class="refund-img" alt="Refund background">

        <div class="refund-content">
            <h1>Refund Policy 💖</h1>
            <p>
                Transparent payments. Clear rules. Safe and respectful support for everyone on AffirmSpace.
            </p>
        </div>

    </section>

    <!-- POLICY CONTENT -->
    <section class="policy-section">

        <div class="policy-header">
            <h2>Payments & Refund Guidelines</h2>
            <p>
                Please review our refund rules carefully before making any purchase or booking a service.
            </p>
        </div>

        <div class="policy-grid">

            <div class="policy-card">
                <h3>1. Secure Payments</h3>
                <p>
                    All payments are processed through authorized third-party gateways such as Razorpay.
                </p>
                <p>
                    AffirmSpace does not store card details, CVV, UPI credentials, or banking passwords.
                </p>
                <p>
                    By completing a transaction, you confirm that you are authorized to use the payment method.
                </p>
            </div>

            <div class="policy-card">
                <h3>2. Counselling Sessions</h3>
                <ul>
                    <li>Full payment is required in advance.</li>
                    <li>Bookings are final once confirmed.</li>
                    <li>No-shows and late arrivals are non-refundable.</li>
                    <li>Completed sessions are non-refundable.</li>
                    <li>If a counsellor cancels, you may reschedule or get a full refund.</li>
                </ul>
                <p>
                    Counselling services are supportive in nature and do not guarantee specific outcomes.
                </p>
            </div>

            <div class="policy-card">
                <h3>3. Subscription Plans</h3>
                <ul>
                    <li>Subscriptions may auto-renew.</li>
                    <li>You can cancel anytime to stop future billing.</li>
                    <li>No refunds for partially used periods.</li>
                    <li>Access continues until the billing cycle ends.</li>
                </ul>
            </div>

            <div class="policy-card">
                <h3>4. Account Suspension & Misuse</h3>
                <ul>
                    <li>Violation of guidelines</li>
                    <li>Harassment or abuse</li>
                    <li>Fraudulent activity</li>
                    <li>Illegal or harmful behavior</li>
                </ul>
                <p>
                    Accounts may be suspended or terminated without refund in such cases.
                </p>
            </div>

            <div class="policy-card">
                <h3>5. Duplicate or Failed Transactions</h3>
                <p>
                    If a duplicate or failed transaction occurs, contact support for review.
                </p>
                <p>
                    Approved refunds are processed within 7 working days, with additional bank processing time.
                </p>
            </div>

            <div class="policy-card">
                <h3>6. International Payments</h3>
                <p>
                    Exchange rates and bank charges may affect the refunded amount.
                </p>
                <p>
                    AffirmSpace is not responsible for differences caused by payment providers.
                </p>
            </div>

            <div class="policy-card">
                <h3>7. Refund Eligibility</h3>
                <p>Refunds are issued only in these cases:</p>
                <ul>
                    <li>Counsellor cancellation</li>
                    <li>Duplicate payment</li>
                    <li>Technical failure of service</li>
                </ul>
                <p>
                    All other payments are non-refundable unless required by law.
                </p>
            </div>

            <div class="policy-card">
                <h3>Contact Support</h3>
                <p>Email: <strong>affirmspace@gmail.com</strong></p>
                <p>
                    Please include your registered email, transaction ID, and payment date.
                </p>
            </div>

        </div>

        <div class="policy-footer">
            © 2026 AffirmSpace — Secure Payments, Honest Policies ✨
        </div>

    </section>
@endsection
