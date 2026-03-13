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

        .refund-parallax {
            position: relative;
            padding: 120px 8%;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        /* IMAGE */

        .refund-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            z-index: -2;
        }

        /* DARK OVERLAY */

        .refund-parallax::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: -1;
        }

        /* TEXT */

        .refund-content {
            max-width: 850px;
            margin: auto;
        }

        .refund-content h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .refund-content p {
            color: #f0f0f0;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        /* MOBILE FIX */

        @media(max-width:1024px) {

            .refund-img {
                position: absolute;
                height: 100%;
            }

            .refund-parallax {
                padding: 100px 8%;
            }

        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="refund-parallax">

        <img src="images/coursel.png" class="refund-img" alt="Refund policy background">

        <div class="refund-content">
            <h2>Refunds & Fairness 💖</h2>

            <p>
                Transparent payments and respectful policies — always.
            </p>
        </div>

    </section>

    <!-- Refund Content -->
    <section class="features">
        <div class="feature-grid">

            <div class="feature-card">
                <h3>1. Payments</h3>
                <p>
                    All payments on AffirmSpace are securely processed through Razorpay.
                    AffirmSpace does not store card numbers, CVV details, UPI credentials,
                    or banking information.
                </p>
            </div>

            <div class="feature-card">
                <h3>2. Counselling Sessions</h3>
                <ul>
                    <li>All counselling sessions must be paid in advance to confirm booking.</li>
                    <li>There is currently no in-app cancellation feature available.</li>
                    <li>Once a session is booked and paid for, the booking is final.</li>
                    <li>No-shows are non-refundable.</li>
                    <li>Completed counselling sessions are non-refundable.</li>
                    <li>If a counsellor cancels or fails to attend, a full refund or rescheduling will be provided.</li>
                    <li>Users should confirm availability before booking.</li>
                </ul>
            </div>

            <div class="feature-card">
                <h3>3. Monthly Subscriptions (Future Feature)</h3>
                <ul>
                    <li>Subscriptions will auto-renew monthly.</li>
                    <li>Users may cancel anytime to stop future renewals.</li>
                    <li>No refunds for partially used subscription periods.</li>
                    <li>Access continues until the end of the billing cycle.</li>
                </ul>
            </div>

            <div class="feature-card">
                <h3>4. Account Suspension or Misuse</h3>
                <ul>
                    <li>Violation of community guidelines</li>
                    <li>Fraudulent activity</li>
                    <li>Harassment or platform misuse</li>
                    <li>Payment disputes or chargebacks</li>
                </ul>
                <p>No refunds will be issued in such cases.</p>
            </div>

            <div class="feature-card">
                <h3>5. Duplicate or Failed Payments</h3>
                <p>
                    Duplicate or failed payment deductions will be reviewed and refunded
                    within 7 working days where applicable.
                </p>
                <p>
                    Approved refunds via Razorpay may take 5–10 business days
                    depending on your bank or UPI provider.
                </p>
            </div>

            <div class="feature-card">
                <h3>6. International Payments</h3>
                <p>
                    Currency conversion differences, exchange rate fluctuations,
                    or bank processing fees may affect the refunded amount.
                    AffirmSpace is not responsible for variations caused by
                    payment providers or financial institutions.
                </p>
            </div>

            <div class="feature-card">
                <h3>Contact Support</h3>
                <p>Email: support@affirmspace.com</p>
            </div>

        </div>

        <p class="disclaimer">
            © 2026 AffirmSpace — Secure Payments, Honest Policies ✨
        </p>
    </section>
@endsection
