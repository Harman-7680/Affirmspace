@extends('layouts.seo')

@section('meta')
    <title>Refund Policy – AffirmSpace</title>

    <meta name="description"
        content="Read AffirmSpace's Refund Policy for counselling sessions, events, payments, cancellations, failed transactions, and refund eligibility.">

    <meta name="author" content="AffirmSpace">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection


@section('css')
    <style id="as-refund-css">
        /* =========================================================
           AFFIRMSPACE REFUND POLICY
           ========================================================= */

        .as-refund-page {
            font-family: 'Inter', sans-serif;
            color: #222;
            background: #fff;
            overflow: hidden;
        }

        .as-refund-page *,
        .as-refund-page *::before,
        .as-refund-page *::after {
            box-sizing: border-box;
        }


        /* =========================================================
           HERO
           ========================================================= */

        .as-refund-hero {
            position: relative;
            min-height: 430px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #111;
        }

        .as-refund-hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .as-refund-hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg,
                    rgba(255, 81, 47, 0.92),
                    rgba(221, 36, 118, 0.88));
            opacity: .91;
        }

        .as-refund-hero-content {
            position: relative;
            z-index: 2;
            width: min(100% - 40px, 950px);
            margin: 0 auto;
            padding: 80px 20px;
            text-align: center;
            color: #fff;
        }

        .as-refund-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 20px;
            padding: 8px 16px;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .as-refund-eyebrow i {
            font-size: 13px;
        }

        .as-refund-hero h1 {
            margin: 0 0 20px;
            font-size: clamp(40px, 5vw, 64px);
            line-height: 1.08;
            font-weight: 800;
            letter-spacing: -1.8px;
        }

        .as-refund-hero p {
            max-width: 760px;
            margin: 0 auto;
            color: rgba(255, 255, 255, .94);
            font-size: 17px;
            line-height: 1.75;
        }


        /* =========================================================
           EFFECTIVE DATE
           ========================================================= */

        .as-refund-intro-section {
            padding: 85px 20px 35px;
            background: #fff;
        }

        .as-refund-container {
            width: min(100%, 1080px);
            margin: 0 auto;
        }

        .as-refund-intro {
            position: relative;
            padding: 34px 38px;
            border: 1px solid #f0e7eb;
            border-radius: 22px;
            background: linear-gradient(135deg,
                    #fff,
                    #fff8fa);
            box-shadow: 0 12px 40px rgba(221, 36, 118, .07);
        }

        .as-refund-intro::before {
            content: "";
            position: absolute;
            top: 0;
            left: 32px;
            right: 32px;
            height: 3px;
            border-radius: 0 0 10px 10px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .as-refund-intro-top {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 20px;
        }

        .as-refund-intro-icon {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: linear-gradient(135deg,
                    rgba(255, 81, 47, .12),
                    rgba(221, 36, 118, .12));
            color: #dd2476;
            font-size: 20px;
        }

        .as-refund-intro h2 {
            margin: 0 0 5px;
            color: #222;
            font-size: 22px;
            line-height: 1.35;
            font-weight: 750;
        }

        .as-refund-effective {
            margin: 0;
            color: #777;
            font-size: 13px;
            line-height: 1.6;
        }

        .as-refund-intro p {
            margin: 0;
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }


        /* =========================================================
           POLICY SECTIONS
           ========================================================= */

        .as-refund-section {
            padding: 35px 20px 85px;
            background: #fff;
        }

        .as-refund-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .as-refund-card {
            position: relative;
            padding: 30px;
            border: 1px solid #eeeeee;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 7px 28px rgba(0, 0, 0, .045);
            transition:
                transform .28s ease,
                box-shadow .28s ease,
                border-color .28s ease;
        }

        .as-refund-card:hover {
            transform: translateY(-4px);
            border-color: rgba(221, 36, 118, .18);
            box-shadow: 0 15px 38px rgba(221, 36, 118, .09);
        }

        .as-refund-card-wide {
            grid-column: 1 / -1;
        }

        .as-refund-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border-radius: 14px;
            background: linear-gradient(135deg,
                    rgba(255, 81, 47, .11),
                    rgba(221, 36, 118, .11));
            color: #dd2476;
            font-size: 19px;
        }

        .as-refund-card h2 {
            margin: 0 0 12px;
            color: #222;
            font-size: 21px;
            line-height: 1.35;
            font-weight: 750;
        }

        .as-refund-card p {
            margin: 0;
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }

        .as-refund-card p+p {
            margin-top: 14px;
        }

        .as-refund-card ul {
            margin: 16px 0 0;
            padding: 0;
            list-style: none;
        }

        .as-refund-card li {
            position: relative;
            margin-bottom: 14px;
            padding-left: 27px;
            color: #555;
            font-size: 14.5px;
            line-height: 1.75;
        }

        .as-refund-card li:last-child {
            margin-bottom: 0;
        }

        .as-refund-card li::before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 2px;
            width: 19px;
            height: 19px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff0f4;
            color: #dd2476;
            font-size: 11px;
            font-weight: 800;
        }

        .as-refund-card li strong {
            color: #333;
            font-weight: 700;
        }


        /* =========================================================
           COUNSELLING / EVENTS
           ========================================================= */

        .as-refund-service-card {
            background:
                linear-gradient(135deg,
                    #fff8fa 0%,
                    #fff 55%,
                    #fff8f5 100%);
        }


        /* =========================================================
           FREE FEATURES NOTICE
           ========================================================= */

        .as-refund-free-card {
            background:
                linear-gradient(135deg,
                    #fff,
                    #fff9fa);
        }

        .as-refund-free-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 15px;
            padding: 7px 12px;
            border-radius: 999px;
            background: #fff0f4;
            color: #dd2476;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .8px;
            text-transform: uppercase;
        }


        /* =========================================================
           ELIGIBILITY
           ========================================================= */

        .as-refund-eligibility-section {
            padding: 85px 20px;
            background: #fafafa;
        }

        .as-refund-section-heading {
            max-width: 720px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .as-refund-section-heading .eyebrow {
            display: inline-block;
            margin-bottom: 12px;
            color: #dd2476;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .as-refund-section-heading h2 {
            margin: 0 0 13px;
            color: #222;
            font-size: clamp(28px, 4vw, 38px);
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .as-refund-section-heading p {
            margin: 0;
            color: #6a6a6a;
            font-size: 15px;
            line-height: 1.75;
        }

        .as-refund-eligibility-grid {
            width: min(100%, 950px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .as-refund-eligibility-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 19px 20px;
            border: 1px solid #eeeeee;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .035);
        }

        .as-refund-eligibility-item i {
            width: 35px;
            height: 35px;
            flex: 0 0 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff0f4;
            color: #dd2476;
            font-size: 13px;
        }

        .as-refund-eligibility-item span {
            color: #444;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 600;
        }

        .as-refund-not-eligible {
            opacity: .88;
        }


        /* =========================================================
           CONTACT SUPPORT
           ========================================================= */

        .as-refund-contact-section {
            padding: 85px 20px;
            background: #fff;
        }

        .as-refund-contact-card {
            position: relative;
            width: min(100%, 1000px);
            margin: 0 auto;
            padding: 45px;
            overflow: hidden;
            border-radius: 26px;
            background: linear-gradient(135deg,
                    #fff5f7,
                    #fff9f5);
            border: 1px solid #f3e4e9;
        }

        .as-refund-contact-card::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            right: -110px;
            top: -120px;
            border-radius: 50%;
            background: rgba(221, 36, 118, .07);
        }

        .as-refund-contact-content {
            position: relative;
            z-index: 2;
            max-width: 780px;
        }

        .as-refund-contact-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            border-radius: 15px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;
            font-size: 20px;
        }

        .as-refund-contact-card h2 {
            margin: 0 0 12px;
            color: #222;
            font-size: 28px;
            line-height: 1.25;
            font-weight: 800;
        }

        .as-refund-contact-card p {
            margin: 0 0 18px;
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }

        .as-refund-email {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #dd2476;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
        }

        .as-refund-email:hover {
            text-decoration: underline;
        }

        .as-refund-contact-details {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .as-refund-contact-detail {
            padding: 15px;
            border: 1px solid #f0e4e8;
            border-radius: 13px;
            background: rgba(255, 255, 255, .75);
        }

        .as-refund-contact-detail span {
            display: block;
            margin-bottom: 5px;
            color: #999;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .as-refund-contact-detail strong {
            color: #444;
            font-size: 13px;
            font-weight: 600;
        }


        /* =========================================================
           FINAL NOTE
           ========================================================= */

        .as-refund-final-section {
            padding: 85px 20px 100px;
            background: #fff;
        }

        .as-refund-final {
            width: min(100%, 850px);
            margin: 0 auto;
            text-align: center;
        }

        .as-refund-final-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
            border-radius: 50%;
            background: linear-gradient(135deg,
                    rgba(255, 81, 47, .12),
                    rgba(221, 36, 118, .12));
            color: #dd2476;
            font-size: 25px;
        }

        .as-refund-final h2 {
            margin: 0 0 16px;
            color: #222;
            font-size: clamp(29px, 4vw, 40px);
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .as-refund-final p {
            max-width: 720px;
            margin: 0 auto;
            color: #666;
            font-size: 16px;
            line-height: 1.85;
        }


        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 900px) {

            .as-refund-hero {
                min-height: 390px;
            }

            .as-refund-grid {
                grid-template-columns: 1fr;
            }

            .as-refund-card-wide {
                grid-column: auto;
            }

            .as-refund-eligibility-grid {
                grid-template-columns: 1fr;
            }

            .as-refund-contact-details {
                grid-template-columns: 1fr;
            }

            .as-refund-intro-section,
            .as-refund-section,
            .as-refund-eligibility-section,
            .as-refund-contact-section {
                padding-left: 18px;
                padding-right: 18px;
            }
        }


        @media (max-width: 650px) {

            .as-refund-hero-content {
                width: min(100% - 24px, 950px);
                padding: 65px 12px;
            }

            .as-refund-hero h1 {
                font-size: 39px;
                letter-spacing: -1px;
            }

            .as-refund-hero p {
                font-size: 15px;
                line-height: 1.7;
            }

            .as-refund-intro {
                padding: 30px 24px;
            }

            .as-refund-intro-top {
                align-items: flex-start;
            }

            .as-refund-card {
                padding: 26px 23px;
            }

            .as-refund-contact-card {
                padding: 32px 25px;
            }

            .as-refund-final-section {
                padding-bottom: 75px;
            }
        }


        @media (max-width: 420px) {

            .as-refund-hero {
                min-height: 365px;
            }

            .as-refund-hero-content {
                padding-top: 55px;
                padding-bottom: 55px;
            }

            .as-refund-eyebrow {
                font-size: 10px;
                padding: 7px 12px;
            }

            .as-refund-hero h1 {
                font-size: 34px;
            }

            .as-refund-intro {
                padding: 26px 20px;
                border-radius: 18px;
            }

            .as-refund-intro-top {
                gap: 13px;
            }

            .as-refund-intro-icon {
                width: 42px;
                height: 42px;
                flex-basis: 42px;
                font-size: 17px;
            }

            .as-refund-intro h2 {
                font-size: 19px;
            }

            .as-refund-card {
                padding: 24px 20px;
                border-radius: 18px;
            }

            .as-refund-card h2 {
                font-size: 19px;
            }

            .as-refund-card p,
            .as-refund-card li {
                font-size: 14px;
            }

            .as-refund-contact-card {
                padding: 28px 20px;
                border-radius: 20px;
            }

            .as-refund-contact-card h2 {
                font-size: 25px;
            }

            .as-refund-final-section {
                padding-left: 18px;
                padding-right: 18px;
            }
        }
    </style>
@endsection


@section('content')
    <div class="as-refund-page">

        {{-- =====================================================
         HERO
         ===================================================== --}}
        <section class="as-refund-hero">

            <img src="{{ asset('images/coursel.png') }}" alt="LGBTQ+ community" class="as-refund-hero-image">

            <div class="as-refund-hero-overlay"></div>

            <div class="as-refund-hero-content">

                <div class="as-refund-eyebrow">
                    <i class="fa-solid fa-receipt"></i>
                    Payments &amp; Refunds
                </div>

                <h1>Refund Policy</h1>

                <p>
                    Transparent payments. Clear rules. Safe and respectful
                    support for everyone on AffirmSpace.
                </p>

            </div>

        </section>


        {{-- =====================================================
         INTRO / EFFECTIVE DATE
         ===================================================== --}}
        <section class="as-refund-intro-section">

            <div class="as-refund-container">

                <div class="as-refund-intro">

                    <div class="as-refund-intro-top">

                        <div class="as-refund-intro-icon">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>

                        <div>

                            <h2>Refund Policy</h2>

                            <p class="as-refund-effective">
                                Effective Date: [DD Month YYYY]
                            </p>

                        </div>

                    </div>

                    <p>
                        This Refund Policy is issued by
                        <strong>[AffirmSpace legal entity name]</strong>,
                        registered at
                        <strong>[registered business address]</strong>
                        ("AffirmSpace," "we," "us," or "our").
                        Please review these rules carefully before making any
                        purchase or booking a service on AffirmSpace.
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
         MAIN POLICY
         ===================================================== --}}
        <section class="as-refund-section">

            <div class="as-refund-container">

                <div class="as-refund-grid">


                    {{-- 1. SECURE PAYMENTS --}}
                    <article class="as-refund-card">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-lock"></i>
                        </div>

                        <h2>1. Secure Payments</h2>

                        <p>
                            All payments are processed through authorized
                            third-party gateways such as Razorpay.
                            AffirmSpace does not store card details, CVV,
                            UPI credentials, or banking passwords.
                        </p>

                        <p>
                            By completing a transaction, you confirm that you
                            are authorized to use the payment method.
                        </p>

                    </article>


                    {{-- 2. COUNSELLING --}}
                    <article class="as-refund-card as-refund-service-card">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>

                        <h2>2. Counselling Sessions</h2>

                        <ul>

                            <li>
                                Full payment is required in advance.
                            </li>

                            <li>
                                Bookings are final once confirmed.
                            </li>

                            <li>
                                No-shows and late arrivals are non-refundable.
                            </li>

                            <li>
                                Completed sessions are non-refundable.
                            </li>

                            <li>
                                If a counsellor cancels, you may reschedule
                                or get a full refund.
                            </li>

                            <li>
                                Counselling services are supportive in nature
                                and do not guarantee specific outcomes.
                            </li>

                        </ul>

                    </article>


                    {{-- 3. EVENTS --}}
                    <article class="as-refund-card as-refund-service-card">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>

                        <h2>3. Events</h2>

                        <p>
                            If AffirmSpace rejects your event — for example,
                            due to content, privacy, or other guideline concerns —
                            your event payment will be fully refunded.
                        </p>

                        <p>
                            Once your event has gone live on the platform,
                            the payment is non-refundable, regardless of turnout
                            or later cancellation by you.
                        </p>

                    </article>


                    {{-- 4. OTHER FEATURES --}}
                    <article class="as-refund-card as-refund-free-card">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>

                        <div class="as-refund-free-badge">
                            <i class="fa-solid fa-check"></i>
                            Currently Free
                        </div>

                        <h2>4. Other Features</h2>

                        <p>
                            At this time, all other features on AffirmSpace —
                            including chat, dating, and community features —
                            are free to use.
                        </p>

                        <p>
                            Only Counselling and Events currently involve payment.
                        </p>

                        <p>
                            Some features may become limited or move to a
                            subscription plan in the future; this policy will
                            be updated accordingly before any such changes
                            take effect.
                        </p>

                    </article>


                    {{-- 5. ACCOUNT SUSPENSION --}}
                    <article class="as-refund-card">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-user-slash"></i>
                        </div>

                        <h2>5. Account Suspension &amp; Misuse</h2>

                        <p>
                            Accounts may be suspended or terminated without
                            refund in cases involving:
                        </p>

                        <ul>

                            <li>
                                Violation of guidelines
                            </li>

                            <li>
                                Harassment or abuse
                            </li>

                            <li>
                                Fraudulent activity
                            </li>

                            <li>
                                Illegal or harmful behavior
                            </li>

                        </ul>

                    </article>


                    {{-- 6. DUPLICATE / FAILED --}}
                    <article class="as-refund-card">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-rotate"></i>
                        </div>

                        <h2>6. Duplicate or Failed Transactions</h2>

                        <p>
                            Event and counselling payments are processed through
                            Razorpay, which is responsible for handling duplicate
                            charges or failed transactions on their end.
                        </p>

                        <p>
                            If you notice a duplicate or failed transaction,
                            please contact our support team for review, and
                            we'll coordinate with Razorpay to resolve it.
                        </p>

                    </article>


                    {{-- 7. REFUND METHOD --}}
                    <article class="as-refund-card">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-money-bill-transfer"></i>
                        </div>

                        <h2>7. Refund Method</h2>

                        <p>
                            Approved refunds are issued back to the same payment
                            method used for the original transaction.
                        </p>

                        <p>
                            Processing takes up to 7 working days on our end,
                            with additional time possible depending on your
                            bank or payment provider.
                        </p>

                    </article>


                    {{-- 8. INTERNATIONAL PAYMENTS --}}
                    <article class="as-refund-card">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-globe"></i>
                        </div>

                        <h2>8. International Payments</h2>

                        <p>
                            Exchange rates and bank charges may affect the
                            refunded amount.
                        </p>

                        <p>
                            AffirmSpace is not responsible for differences
                            caused by payment providers.
                        </p>

                    </article>


                    {{-- 9. REFUND ELIGIBILITY --}}
                    <article class="as-refund-card as-refund-card-wide">

                        <div class="as-refund-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <h2>9. Refund Eligibility</h2>

                        <p>
                            Refunds are issued only in these cases:
                        </p>

                        <ul>

                            <li>
                                Counsellor cancellation
                            </li>

                            <li>
                                Event rejected by AffirmSpace before going live
                            </li>

                            <li>
                                Duplicate payment
                            </li>

                            <li>
                                Technical failure of service
                            </li>

                        </ul>

                        <p style="margin-top:20px;">
                            All other payments are non-refundable unless required
                            by law.
                        </p>

                    </article>

                </div>

            </div>

        </section>


        {{-- =====================================================
         ELIGIBILITY SUMMARY
         ===================================================== --}}
        <section class="as-refund-eligibility-section">

            <div class="as-refund-section-heading">

                <span class="eyebrow">At a Glance</span>

                <h2>When Can You Get a Refund?</h2>

                <p>
                    The following situations are covered by AffirmSpace's
                    current refund policy.
                </p>

            </div>


            <div class="as-refund-eligibility-grid">

                <div class="as-refund-eligibility-item">

                    <i class="fa-solid fa-user-doctor"></i>

                    <span>
                        Counsellor cancels your session
                    </span>

                </div>


                <div class="as-refund-eligibility-item">

                    <i class="fa-solid fa-calendar-xmark"></i>

                    <span>
                        Your event is rejected before going live
                    </span>

                </div>


                <div class="as-refund-eligibility-item">

                    <i class="fa-solid fa-copy"></i>

                    <span>
                        You were charged twice for the same transaction
                    </span>

                </div>


                <div class="as-refund-eligibility-item">

                    <i class="fa-solid fa-gears"></i>

                    <span>
                        A technical failure prevents the paid service
                        from being provided
                    </span>

                </div>

            </div>

        </section>


        {{-- =====================================================
         CONTACT SUPPORT
         ===================================================== --}}
        <section class="as-refund-contact-section">

            <div class="as-refund-contact-card">

                <div class="as-refund-contact-content">

                    <div class="as-refund-contact-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>

                    <h2>Need Help With a Refund?</h2>

                    <p>
                        Contact our support team if you have a question about
                        a payment, refund, duplicate transaction, or failed
                        transaction.
                    </p>

                    <a href="mailto:info@affirmspace.com" class="as-refund-email">
                        <i class="fa-solid fa-envelope"></i>
                        info@affirmspace.com
                    </a>


                    <div class="as-refund-contact-details">

                        <div class="as-refund-contact-detail">
                            <span>Include</span>
                            <strong>Your registered email</strong>
                        </div>

                        <div class="as-refund-contact-detail">
                            <span>Include</span>
                            <strong>Transaction ID</strong>
                        </div>

                        <div class="as-refund-contact-detail">
                            <span>Include</span>
                            <strong>Payment date</strong>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
         FINAL NOTE
         ===================================================== --}}
        <section class="as-refund-final-section">

            <div class="as-refund-final">

                <div class="as-refund-final-icon">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>

                <h2>Clear Payments. Clear Expectations.</h2>

                <p>
                    We want you to understand how payments and refunds work
                    before you purchase or book a service on AffirmSpace.
                    If you're unsure about a transaction, contact us before
                    making a purchase whenever possible.
                </p>

            </div>

        </section>

    </div>
@endsection
