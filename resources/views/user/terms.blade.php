@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Policy – AffirmSpace</title>

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
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section>
        <h2>Refund Policy 💖</h2>
        <p>
            Transparent payments. Clear rules. Safe support for everyone.
        </p>
    </section>

    <!-- Refund Content -->
    <section class="features">
        <div class="feature-grid">

            <div class="feature-card">
                <h3>1. Secure Payments</h3>
                <p>
                    All payments on AffirmSpace are securely processed through authorized third-party
                    payment gateways such as Razorpay.
                </p>
                <p>
                    AffirmSpace does not store card numbers, CVV details, UPI credentials,
                    or banking passwords.
                </p>
                <p>
                    By completing a transaction, you confirm that you are authorized
                    to use the selected payment method.
                </p>
            </div>

            <div class="feature-card">
                <h3>2. Counselling Sessions</h3>
                <ul>
                    <li>Full payment is required in advance to confirm session booking.</li>
                    <li>Bookings become final once payment is successfully processed.</li>
                    <li>No-shows and late arrivals are non-refundable.</li>
                    <li>Completed sessions are non-refundable.</li>
                    <li>If a counsellor cancels or fails to attend, users may choose rescheduling or a full refund.</li>
                </ul>
                <p>
                    Counselling services are supportive in nature and do not guarantee specific outcomes.
                </p>
            </div>

            <div class="feature-card">
                <h3>3. Subscription Plans</h3>
                <ul>
                    <li>Subscription plans (if applicable) are billed on a recurring basis.</li>
                    <li>Subscriptions may auto-renew unless cancelled before the next billing cycle.</li>
                    <li>Users may cancel anytime to stop future renewals.</li>
                    <li>No refunds for partially used subscription periods.</li>
                    <li>Access continues until the end of the active billing cycle.</li>
                </ul>
            </div>

            <div class="feature-card">
                <h3>4. Account Suspension & Misuse</h3>
                <ul>
                    <li>Violation of community guidelines</li>
                    <li>Harassment, hate speech, or abuse</li>
                    <li>Fraudulent activity or false payment disputes</li>
                    <li>Platform misuse or illegal activity</li>
                </ul>
                <p>
                    In such cases, AffirmSpace reserves the right to suspend or permanently terminate accounts
                    without issuing refunds.
                </p>
            </div>

            <div class="feature-card">
                <h3>5. Duplicate or Failed Transactions</h3>
                <p>
                    In case of duplicate payments or failed transactions resulting in unintended deductions,
                    users may contact support for review.
                </p>
                <p>
                    Approved refunds will be processed within 7 working days.
                    It may take an additional 5–10 business days for the amount to reflect
                    depending on your bank or payment provider.
                </p>
            </div>

            <div class="feature-card">
                <h3>6. International Payments</h3>
                <p>
                    Currency conversion rates, exchange fluctuations,
                    and bank processing charges may affect the refunded amount.
                </p>
                <p>
                    AffirmSpace is not responsible for variations caused by
                    financial institutions or payment processors.
                </p>
            </div>

            <div class="feature-card">
                <h3>7. Refund Eligibility</h3>
                <p>Refunds may be issued only in the following cases:</p>
                <ul>
                    <li>Counsellor cancellation without rescheduling</li>
                    <li>Duplicate payment deduction</li>
                    <li>Technical errors preventing service delivery</li>
                </ul>
                <p>
                    All other payments are non-refundable unless required by applicable law.
                </p>
            </div>

            <div class="feature-card">
                <h3>Contact Support</h3>
                <p>
                    For billing questions or refund requests, please contact:
                </p>
                <p><strong>Email:</strong> support@affirmspace.com</p>
                <p>
                    Please include your registered email ID, transaction ID,
                    and payment date for faster assistance.
                </p>
            </div>

        </div>

        <p class="disclaimer">
            © 2026 AffirmSpace — Secure Payments, Honest Policies ✨
        </p>
    </section>
@endsection
