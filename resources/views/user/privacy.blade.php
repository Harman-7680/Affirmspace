@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Privacy Policy – AffirmSpace</title>

    <meta name="description"
        content="Read the AffirmSpace Privacy Policy to understand how we collect, use, protect, retain, and manage personal information across our LGBTQ+ platform.">

    <meta name="author" content="Affirm Space">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        /* =========================================================
                   AFFIRMSPACE PRIVACY PAGE
                ========================================================= */

        .as-privacy-page {
            background: #fafafa;
            color: #222;
            font-family: 'Inter', sans-serif;
        }

        /* =========================================================
                   HERO
                ========================================================= */

        .as-privacy-hero {
            position: relative;
            min-height: 430px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 110px 7%;
            overflow: hidden;
            text-align: center;
            color: #fff;
        }

        .as-privacy-hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .as-privacy-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg,
                    rgba(255, 81, 47, 0.82),
                    rgba(221, 36, 118, 0.82));
            z-index: 1;
        }

        .as-privacy-hero::after {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -300px;
            right: -150px;
            z-index: 2;
        }

        .as-privacy-hero-content {
            position: relative;
            z-index: 3;
            max-width: 850px;
            margin: 0 auto;
        }

        .as-privacy-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .as-privacy-hero h1 {
            margin: 0 0 18px;
            font-size: clamp(2.3rem, 5vw, 4rem);
            line-height: 1.08;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .as-privacy-hero p {
            max-width: 760px;
            margin: 0 auto;
            color: rgba(255, 255, 255, 0.94);
            font-size: 17px;
            line-height: 1.8;
        }

        /* =========================================================
                   MAIN
                ========================================================= */

        .as-privacy-main {
            padding: 75px 7% 100px;
        }

        .as-privacy-container {
            max-width: 1120px;
            margin: 0 auto;
        }

        /* =========================================================
                   INTRO
                ========================================================= */

        .as-privacy-intro {
            display: grid;
            grid-template-columns: 1.4fr 0.6fr;
            gap: 28px;
            margin-bottom: 35px;
        }

        .as-privacy-intro-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 22px;
            padding: 30px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.045);
        }

        .as-privacy-intro-card h2 {
            margin: 0 0 12px;
            font-size: 22px;
            font-weight: 800;
            color: #222;
        }

        .as-privacy-intro-card p {
            margin: 0;
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }

        .as-privacy-effective {
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg,
                    #fff5f2,
                    #fff1f7);
            border: 1px solid rgba(221, 36, 118, 0.12);
        }

        .as-privacy-effective-label {
            margin-bottom: 7px;
            color: #888;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .as-privacy-effective-value {
            color: #dd2476;
            font-size: 17px;
            font-weight: 800;
        }

        /* =========================================================
                   HIGHLIGHTS
                ========================================================= */

        .as-privacy-highlights {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 45px;
        }

        .as-privacy-highlight {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 22px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 18px;
            transition: 0.3s ease;
        }

        .as-privacy-highlight:hover {
            transform: translateY(-3px);
            border-color: rgba(221, 36, 118, 0.18);
            box-shadow: 0 12px 28px rgba(221, 36, 118, 0.08);
        }

        .as-privacy-highlight-icon {
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: linear-gradient(135deg,
                    #fff0eb,
                    #ffeaf3);
            color: #dd2476;
            font-size: 18px;
        }

        .as-privacy-highlight h3 {
            margin: 1px 0 5px;
            font-size: 14px;
            font-weight: 800;
        }

        .as-privacy-highlight p {
            margin: 0;
            color: #777;
            font-size: 13px;
            line-height: 1.6;
        }

        /* =========================================================
                   POLICY SECTIONS
                ========================================================= */

        .as-privacy-sections {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .as-privacy-section {
            position: relative;
            background: #fff;
            border: 1px solid #ededed;
            border-radius: 20px;
            padding: 30px 34px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.035);
            transition: 0.3s ease;
        }

        .as-privacy-section:hover {
            border-color: rgba(221, 36, 118, 0.14);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.055);
        }

        .as-privacy-section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 17px;
        }

        .as-privacy-number {
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: linear-gradient(135deg,
                    #ff512f,
                    #dd2476);
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 7px 18px rgba(221, 36, 118, 0.18);
        }

        .as-privacy-section h2 {
            margin: 0;
            font-size: 19px;
            font-weight: 800;
            color: #222;
        }

        .as-privacy-section p {
            margin: 0 0 13px;
            color: #5f5f5f;
            font-size: 14.5px;
            line-height: 1.8;
        }

        .as-privacy-section p:last-child {
            margin-bottom: 0;
        }

        .as-privacy-section ul {
            margin: 0;
            padding: 0;
            list-style: none;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 9px 25px;
        }

        .as-privacy-section li {
            position: relative;
            padding-left: 21px;
            color: #5f5f5f;
            font-size: 14px;
            line-height: 1.65;
        }

        .as-privacy-section li::before {
            content: "";
            position: absolute;
            left: 0;
            top: 9px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: linear-gradient(135deg,
                    #ff512f,
                    #dd2476);
        }

        .as-privacy-strong {
            color: #333;
            font-weight: 700;
        }

        /* =========================================================
                   THIRD PARTY TABLE
                ========================================================= */

        .as-privacy-table-wrap {
            width: 100%;
            overflow-x: auto;
            margin-top: 18px;
            border: 1px solid #eee;
            border-radius: 15px;
        }

        .as-privacy-table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }

        .as-privacy-table th {
            padding: 15px 16px;
            background: #fafafa;
            color: #333;
            font-size: 13px;
            font-weight: 800;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .as-privacy-table td {
            padding: 15px 16px;
            color: #666;
            font-size: 13px;
            line-height: 1.6;
            vertical-align: top;
            border-bottom: 1px solid #f0f0f0;
        }

        .as-privacy-table tr:last-child td {
            border-bottom: none;
        }

        .as-privacy-provider {
            color: #dd2476;
            font-weight: 800;
        }

        /* =========================================================
                   NOTICE
                ========================================================= */

        .as-privacy-notice {
            margin-top: 25px;
            padding: 20px 22px;
            border-radius: 16px;
            background: #fff7f4;
            border: 1px solid rgba(255, 81, 47, 0.14);
        }

        .as-privacy-notice strong {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-size: 14px;
        }

        .as-privacy-notice p {
            margin: 0;
            color: #666;
            font-size: 13px;
            line-height: 1.7;
        }

        /* =========================================================
                   CONTACT
                ========================================================= */

        .as-privacy-contact {
            margin-top: 28px;
            padding: 32px;
            border-radius: 22px;
            background: linear-gradient(135deg,
                    #ff512f,
                    #dd2476);
            color: #fff;
            box-shadow: 0 18px 40px rgba(221, 36, 118, 0.16);
        }

        .as-privacy-contact h2 {
            margin: 0 0 10px;
            font-size: 22px;
            font-weight: 800;
        }

        .as-privacy-contact p {
            margin: 0 0 12px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            line-height: 1.7;
        }

        .as-privacy-email {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-top: 5px;
            color: #fff !important;
            font-size: 15px;
            font-weight: 800;
            text-decoration: none;
        }

        .as-privacy-email:hover {
            text-decoration: underline;
        }

        /* =========================================================
                   FOOTNOTE
                ========================================================= */

        .as-privacy-footer-note {
            margin-top: 25px;
            color: #888;
            font-size: 12px;
            line-height: 1.7;
            text-align: center;
        }

        /* =========================================================
                   RESPONSIVE
                ========================================================= */

        @media (max-width: 900px) {

            .as-privacy-intro {
                grid-template-columns: 1fr;
            }

            .as-privacy-highlights {
                grid-template-columns: 1fr;
            }

            .as-privacy-section ul {
                grid-template-columns: 1fr;
            }

            .as-privacy-hero {
                min-height: 390px;
                padding: 95px 6%;
            }

            .as-privacy-main {
                padding: 60px 6% 80px;
            }
        }

        @media (max-width: 600px) {

            .as-privacy-hero {
                min-height: 360px;
                padding: 80px 5%;
            }

            .as-privacy-hero h1 {
                font-size: 2.35rem;
            }

            .as-privacy-hero p {
                font-size: 14px;
                line-height: 1.7;
            }

            .as-privacy-main {
                padding: 45px 5% 65px;
            }

            .as-privacy-intro-card {
                padding: 23px;
                border-radius: 18px;
            }

            .as-privacy-section {
                padding: 24px 20px;
                border-radius: 17px;
            }

            .as-privacy-section-header {
                align-items: flex-start;
            }

            .as-privacy-section h2 {
                font-size: 17px;
                line-height: 1.4;
            }

            .as-privacy-number {
                flex-basis: 38px;
                width: 38px;
                height: 38px;
            }

            .as-privacy-section p,
            .as-privacy-section li {
                font-size: 13.5px;
            }

            .as-privacy-contact {
                padding: 25px 22px;
            }
        }

        @media (max-width: 380px) {

            .as-privacy-hero h1 {
                font-size: 2rem;
            }

            .as-privacy-eyebrow {
                font-size: 10px;
            }

            .as-privacy-highlight {
                padding: 18px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="as-privacy-page">

        {{-- =========================================================
         HERO
    ========================================================== --}}

        <section class="as-privacy-hero">

            <img src="{{ asset('images/coursel.png') }}" class="as-privacy-hero-image"
                alt="LGBTQ community celebrating pride with rainbow flags and joy">

            <div class="as-privacy-hero-content">

                <div class="as-privacy-eyebrow">
                    🔐 Privacy &amp; Security
                </div>

                <h1>Your Privacy Matters</h1>

                <p>
                    This Privacy Policy explains how <strong>Affirm Space</strong>
                    collects, uses, protects, and manages information when you use
                    the AffirmSpace platform, website, and app.
                </p>

            </div>

        </section>


        {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

        <main class="as-privacy-main">

            <div class="as-privacy-container">


                {{-- INTRO --}}

                <div class="as-privacy-intro">

                    <div class="as-privacy-intro-card">

                        <h2>Privacy at AffirmSpace</h2>

                        <p>
                            AffirmSpace is an 18+ LGBTQ+ platform designed for
                            dating, chat, community, events, and access to
                            LGBTQ+-friendly counselling and support. We aim to
                            handle personal information responsibly and provide
                            users with meaningful control over their information.
                        </p>

                    </div>

                    <div class="as-privacy-intro-card as-privacy-effective">

                        <div class="as-privacy-effective-label">
                            Effective Date
                        </div>

                        <div class="as-privacy-effective-value">
                            22 September 2026
                        </div>

                    </div>

                </div>


                {{-- QUICK HIGHLIGHTS --}}

                <div class="as-privacy-highlights">

                    <div class="as-privacy-highlight">

                        <div class="as-privacy-highlight-icon">
                            🔒
                        </div>

                        <div>
                            <h3>Privacy Focused</h3>

                            <p>
                                We do not sell or rent your personal data.
                            </p>
                        </div>

                    </div>


                    <div class="as-privacy-highlight">

                        <div class="as-privacy-highlight-icon">
                            🛡
                        </div>

                        <div>
                            <h3>18+ Platform</h3>

                            <p>
                                AffirmSpace is intended for adults aged 18 and above.
                            </p>
                        </div>

                    </div>


                    <div class="as-privacy-highlight">

                        <div class="as-privacy-highlight-icon">
                            🗑
                        </div>

                        <div>
                            <h3>Instant Account Deletion</h3>

                            <p>
                                User data is deleted from our active systems when
                                an account is deleted.
                            </p>
                        </div>

                    </div>

                </div>


                {{-- POLICY SECTIONS --}}

                <div class="as-privacy-sections">


                    {{-- 1 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">01</div>

                            <h2>Information We Collect</h2>

                        </div>

                        <ul>

                            <li>
                                Name, email address or phone number
                            </li>

                            <li>
                                Gender identity, pronouns, profile biography
                                and photos
                            </li>

                            <li>
                                Posts, chats and information associated with
                                counselling services
                            </li>

                            <li>
                                Payment confirmation information processed
                                through Razorpay
                            </li>

                            <li>
                                Device information, IP address and usage data
                            </li>

                            <li>
                                Push notification tokens
                            </li>

                            <li>
                                Approximate location information through LocationIQ
                            </li>

                            <li>
                                Analytics information through Google Analytics
                                and Firebase Analytics
                            </li>

                        </ul>

                    </section>


                    {{-- 2 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">02</div>

                            <h2>Sensitive Personal Information</h2>

                        </div>

                        <p>
                            Certain information provided through AffirmSpace,
                            including information relating to gender identity,
                            pronouns, sexual orientation, or other aspects of
                            identity, may be considered sensitive personal
                            information under applicable laws.
                        </p>

                        <p>
                            Where processing is based on consent, we aim to obtain
                            consent in accordance with applicable requirements.
                            You may contact us if you have questions about how
                            your information is processed or wish to exercise
                            applicable rights.
                        </p>

                    </section>


                    {{-- 3 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">03</div>

                            <h2>How We Use Your Information</h2>

                        </div>

                        <ul>

                            <li>
                                Creating and maintaining your account
                            </li>

                            <li>
                                Providing platform features and services
                            </li>

                            <li>
                                Providing access to counselling services
                            </li>

                            <li>
                                Processing payments and related transactions
                            </li>

                            <li>
                                Improving platform performance and experience
                            </li>

                            <li>
                                Sending push notifications and service communications
                            </li>

                            <li>
                                Maintaining platform safety and preventing abuse
                            </li>

                            <li>
                                Meeting applicable legal and compliance requirements
                            </li>

                        </ul>

                        <div class="as-privacy-notice">

                            <strong>Our data-selling policy</strong>

                            <p>
                                Affirm Space does not sell or rent your personal
                                data.
                            </p>

                        </div>

                    </section>


                    {{-- 4 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">04</div>

                            <h2>Payments</h2>

                        </div>

                        <p>
                            Payments made through AffirmSpace are processed using
                            Razorpay. Affirm Space does not store full payment
                            card numbers or CVV codes on its own systems.
                        </p>

                        <p>
                            Payment processing may involve information being
                            provided directly to Razorpay in accordance with its
                            applicable privacy and security practices.
                        </p>

                    </section>


                    {{-- 5 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">05</div>

                            <h2>Third-Party Services &amp; Data Sharing</h2>

                        </div>

                        <p>
                            AffirmSpace uses certain third-party services to
                            operate, secure, analyse, and improve the platform.
                            The information shared with these providers depends
                            on how each service is integrated into the platform.
                        </p>

                        <div class="as-privacy-table-wrap">

                            <table class="as-privacy-table">

                                <thead>

                                    <tr>
                                        <th>Service</th>
                                        <th>Purpose</th>
                                        <th>Information Shared</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                        <td class="as-privacy-provider">
                                            Firebase
                                        </td>

                                        <td>
                                            App analytics, performance and
                                            related functionality
                                        </td>

                                        <td>
                                            Device, app usage, performance,
                                            diagnostic and related technical
                                            information as configured in the
                                            AffirmSpace app
                                        </td>

                                    </tr>


                                    <tr>

                                        <td class="as-privacy-provider">
                                            Google Analytics
                                        </td>

                                        <td>
                                            Understanding website usage and
                                            improving the service
                                        </td>

                                        <td>
                                            Website usage and analytics
                                            information collected through the
                                            Google Analytics implementation
                                        </td>

                                    </tr>


                                    <tr>

                                        <td class="as-privacy-provider">
                                            LocationIQ
                                        </td>

                                        <td>
                                            Location-related functionality,
                                            including location-based features
                                        </td>

                                        <td>
                                            Approximate location information
                                            required for relevant location-based
                                            functionality
                                        </td>

                                    </tr>


                                    <tr>

                                        <td class="as-privacy-provider">
                                            Razorpay
                                        </td>

                                        <td>
                                            Payment processing
                                        </td>

                                        <td>
                                            Payment and transaction information
                                            required to process the payment
                                        </td>

                                    </tr>


                                    <tr>

                                        <td class="as-privacy-provider">
                                            Jitsi
                                        </td>

                                        <td>
                                            Voice and video calling
                                        </td>

                                        <td>
                                            An AffirmSpace-generated unique user
                                            identifier and technical session
                                            information required to establish and
                                            operate the call. AffirmSpace does not
                                            share the user's email address with
                                            Jitsi.
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <div class="as-privacy-notice">

                            <strong>Counsellor access</strong>

                            <p>
                                When a counselling session is assigned or booked,
                                the counsellor can see the user's name and profile
                                image associated with that session. Counsellors
                                cannot access the user's email address, location,
                                or general AffirmSpace account data.
                            </p>

                        </div>

                        <div class="as-privacy-notice">

                            <strong>User-to-user privacy</strong>

                            <p>
                                Users cannot access or view another user's email
                                address or location through the AffirmSpace
                                website or app.
                            </p>

                        </div>

                    </section>


                    {{-- 6 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">06</div>

                            <h2>International Data Transfers &amp; Hosting</h2>

                        </div>

                        <p>
                            AffirmSpace's platform data is currently hosted using
                            PECK Web Hosting infrastructure.
                        </p>

                        <p>
                            Affirm Space is based in
                            <span class="as-privacy-strong">
                                Mohali, Punjab, India.
                            </span>
                        </p>

                        <p>
                            Because hosting infrastructure and third-party
                            services may operate in locations different from
                            AffirmSpace's office location, information may be
                            processed outside India depending on the relevant
                            service provider and infrastructure.
                        </p>

                    </section>


                    {{-- 7 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">07</div>

                            <h2>Security Measures</h2>

                        </div>

                        <p>
                            We use reasonable technical and organizational
                            measures intended to protect personal information
                            against unauthorized access, misuse, loss, alteration,
                            or disclosure.
                        </p>

                        <p>
                            These measures may include access controls, secure
                            connections, authentication controls, and appropriate
                            safeguards for the systems used to operate
                            AffirmSpace.
                        </p>

                        <p>
                            AffirmSpace does not maintain backups of user data.
                        </p>

                    </section>


                    {{-- 8 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">08</div>

                            <h2>Data Breach Notification</h2>

                        </div>

                        <p>
                            If a personal data breach occurs, Affirm Space will
                            take appropriate steps to investigate, contain, and
                            address the incident and provide notifications where
                            required by applicable law.
                        </p>

                    </section>


                    {{-- 9 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">09</div>

                            <h2>Cookies &amp; Analytics</h2>

                        </div>

                        <p>
                            AffirmSpace may use analytics technologies, including
                            Google Analytics and Firebase Analytics, to understand
                            how the platform is used, monitor performance, and
                            improve the user experience.
                        </p>

                        <p>
                            Depending on the platform and technology involved,
                            these services may use cookies, identifiers, or
                            similar technologies.
                        </p>

                    </section>


                    {{-- 10 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">10</div>

                            <h2>Your Privacy Rights &amp; User Control</h2>

                        </div>

                        <p>
                            Depending on applicable law, you may have rights
                            relating to the personal information we hold about
                            you, including:
                        </p>

                        <ul>

                            <li>
                                Requesting access to your personal information
                            </li>

                            <li>
                                Requesting correction of inaccurate information
                            </li>

                            <li>
                                Requesting deletion of personal information
                            </li>

                            <li>
                                Withdrawing consent where processing is based on
                                consent
                            </li>

                            <li>
                                Raising a privacy-related complaint or grievance
                            </li>

                        </ul>

                        <p style="margin-top:18px;">
                            You can contact us at
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=info@affirmspace.com" target="_blank"
                                style="color:#dd2476;font-weight:700;text-decoration:none;">
                                info@affirmspace.com
                            </a>

                            for privacy-related requests.
                        </p>

                    </section>


                    {{-- 11 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">11</div>

                            <h2>Data Retention &amp; Account Deletion</h2>

                        </div>

                        <p>
                            AffirmSpace provides account deletion functionality
                            through the website and app.
                        </p>

                        <p>
                            When a user deletes their account, the associated user
                            data is deleted immediately from AffirmSpace's active
                            systems.
                        </p>

                        <p>
                            AffirmSpace does not maintain backups of user data.
                            As a result, deleted user data is not retained in
                            AffirmSpace backup systems.
                        </p>

                        <p>
                            Certain information may nevertheless be retained where
                            required by applicable law or where necessary for
                            legitimate security, fraud-prevention, dispute
                            resolution, or compliance purposes.
                        </p>

                    </section>


                    {{-- 12 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">12</div>

                            <h2>18+ Requirement &amp; Child Safety</h2>

                        </div>

                        <p>
                            AffirmSpace is intended only for people aged 18 years
                            or older. Users must not create or maintain an account
                            if they are under 18.
                        </p>

                        <p>
                            AffirmSpace maintains a zero-tolerance approach toward
                            child sexual abuse, exploitation, grooming, or harmful
                            behaviour involving minors.
                        </p>

                        <p>
                            If we become aware of an account that violates our
                            age requirements or involves prohibited activity, we
                            may suspend or remove the account and take other
                            appropriate action, including reporting to relevant
                            authorities where required.
                        </p>

                        <p>
                            To report harmful content or behaviour, contact:
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=info@affirmspace.com" target="_blank"
                                style="color:#dd2476;font-weight:700;text-decoration:none;">
                                info@affirmspace.com
                            </a>
                        </p>

                    </section>


                    {{-- 13 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">13</div>

                            <h2>Registered Entity &amp; Contact Information</h2>

                        </div>

                        <p>
                            <span class="as-privacy-strong">
                                Legal entity:
                            </span>
                            Affirm Space
                        </p>

                        <p>
                            <span class="as-privacy-strong">
                                Registered country:
                            </span>
                            India
                        </p>

                        <p>
                            <span class="as-privacy-strong">
                                Business location:
                            </span>
                            Mohali, Punjab, India
                        </p>

                        <p>
                            <span class="as-privacy-strong">
                                Privacy contact:
                            </span>

                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=info@affirmspace.com" target="_blank"
                                style="color:#dd2476;font-weight:700;text-decoration:none;">
                                info@affirmspace.com
                            </a>
                        </p>

                    </section>


                    {{-- 14 --}}

                    <section class="as-privacy-section">

                        <div class="as-privacy-section-header">

                            <div class="as-privacy-number">14</div>

                            <h2>Changes to This Privacy Policy</h2>

                        </div>

                        <p>
                            We may update this Privacy Policy from time to time
                            to reflect changes to our services, technology,
                            business practices, or applicable legal requirements.
                        </p>

                        <p>
                            When material changes are made, we may provide
                            appropriate notice through the website, app, or other
                            available communication channels and update the
                            effective date shown at the beginning of this policy.
                        </p>

                    </section>


                    {{-- CONTACT --}}

                    <div class="as-privacy-contact">

                        <h2>Questions About Your Privacy?</h2>

                        <p>
                            If you have a question about this Privacy Policy,
                            your personal information, account deletion, or a
                            privacy-related concern, contact the AffirmSpace team.
                        </p>

                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=info@affirmspace.com" target="_blank" class="as-privacy-email">
                            ✉ info@affirmspace.com
                        </a>

                    </div>


                    <div class="as-privacy-footer-note">
                        This Privacy Policy describes the current privacy and
                        data-handling practices of Affirm Space and may be updated
                        when our services, technology, or legal requirements change.
                    </div>

                </div>

            </div>

        </main>

    </div>
@endsection
