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
        <a href="{{ route('/') }}" class="logo-link">
            <img src="images/welcomepage.png" alt="AffirmSpace Logo">
        </a>
    </header>

    <div class="container">

        <section class="hero">
            <h1>Refunds & Fairness 💖</h1>
            <p>
                Transparent payments and respectful policies — always.
            </p>
        </section>

        <section class="glass">
            <h2 class="section-title">Payments</h2>
            <p>
                All payments on AffirmSpace are securely processed through
                <strong>Razorpay</strong>. We never store your card or UPI details.
            </p>
        </section>

        <section class="glass">
            <h2 class="section-title">Refund Eligibility</h2>
            <ul>
                <li>Refund requests must be made within 7 days</li>
                <li>Unused services may be eligible</li>
                <li>Completed counselling sessions are non-refundable</li>
                <li>No refunds for misuse or policy violations</li>
            </ul>
        </section>

        <section class="glass">
            <h2 class="section-title">Processing Time</h2>
            <ul>
                <li>Approved refunds processed via Razorpay</li>
                <li>5–10 business days depending on bank/UPI</li>
            </ul>
        </section>

        <section class="glass">
            <h2 class="section-title">Failed or Duplicate Payments</h2>
            <p>
                Any duplicate or failed payment deductions are automatically refunded
                within 7 working days.
            </p>
        </section>

        <section class="glass">
            <h2 class="section-title">Contact Support</h2>
            <p>Email: <strong>support@affirmspace.com</strong></p>
        </section>

        <footer>
            © 2025 AffirmSpace — Secure Payments, Honest Policies ✨
        </footer>

    </div>
</body>

</html>
