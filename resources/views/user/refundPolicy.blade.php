<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Policy – AffirmSpace</title>

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
        <h2>Refunds & Fairness 💖</h2>
        <p>
            Transparent payments and respectful policies — always.
        </p>
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