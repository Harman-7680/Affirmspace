@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Terms & Conditions – AffirmSpace</title>

    <meta name="description"
        content="Read the Terms & Conditions governing your use of AffirmSpace, including account responsibilities, community rules, counselling, payments, user content, privacy, and platform safety.">

    <meta name="author" content="AffirmSpace">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection


@section('css')
    <style>
        /* =========================================================
           AFFIRMSPACE TERMS & CONDITIONS
           Scoped styling — does not interfere with global layout
        ========================================================= */

        .as-terms-page {
            font-family: 'Inter', sans-serif;
            color: #222;
            background: #fff;
        }

        .as-terms-page *,
        .as-terms-page *::before,
        .as-terms-page *::after {
            box-sizing: border-box;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .as-terms-hero {
            position: relative;
            min-height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 110px 7%;
            overflow: hidden;
            text-align: center;
            color: #fff;
        }

        .as-terms-hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .as-terms-hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg,
                    rgba(255, 81, 47, 0.70),
                    rgba(221, 36, 118, 0.72)),
                rgba(0, 0, 0, 0.45);
            z-index: 1;
        }

        .as-terms-hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        .as-terms-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            padding: 8px 16px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .as-terms-eyebrow i {
            font-size: 13px;
        }

        .as-terms-hero h1 {
            margin: 0 0 18px;
            font-size: clamp(2.2rem, 5vw, 4rem);
            line-height: 1.08;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .as-terms-hero-description {
            max-width: 760px;
            margin: 0 auto;
            color: rgba(255, 255, 255, 0.92);
            font-size: 17px;
            line-height: 1.75;
        }

        .as-terms-effective {
            margin-top: 24px;
            color: rgba(255, 255, 255, 0.82);
            font-size: 13px;
            font-weight: 600;
        }


        /* =========================================================
           INTRO
        ========================================================= */

        .as-terms-intro {
            padding: 75px 7% 25px;
            background: #fff;
        }

        .as-terms-intro-inner {
            max-width: 1000px;
            margin: 0 auto;
        }

        .as-terms-intro-box {
            padding: 28px 32px;
            border: 1px solid #f0e5ea;
            border-radius: 18px;
            background: linear-gradient(135deg,
                    #fff8fa,
                    #fff);
            box-shadow: 0 10px 35px rgba(221, 36, 118, 0.06);
        }

        .as-terms-intro-box p {
            margin: 0;
            color: #555;
            font-size: 15px;
            line-height: 1.8;
        }

        .as-terms-intro-box strong {
            color: #222;
        }


        /* =========================================================
           MAIN CONTENT
        ========================================================= */

        .as-terms-content {
            padding: 45px 7% 100px;
            background: #fff;
        }

        .as-terms-container {
            max-width: 1050px;
            margin: 0 auto;
        }


        /* =========================================================
           SECTION
        ========================================================= */

        .as-terms-block {
            position: relative;
            margin-bottom: 22px;
            padding: 32px 34px;
            border: 1px solid #eeeeee;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.045);
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }

        .as-terms-block:hover {
            transform: translateY(-2px);
            border-color: rgba(221, 36, 118, 0.16);
            box-shadow: 0 14px 38px rgba(221, 36, 118, 0.07);
        }

        .as-terms-block-header {
            display: flex;
            align-items: flex-start;
            gap: 17px;
            margin-bottom: 17px;
        }

        .as-terms-number {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(135deg, #fff0f4, #fff6f0);
            color: #dd2476;
            font-size: 14px;
            font-weight: 800;
        }

        .as-terms-block h2 {
            margin: 5px 0 0;
            color: #171717;
            font-size: 19px;
            line-height: 1.35;
            font-weight: 750;
        }

        .as-terms-block p {
            margin: 0 0 13px;
            color: #5d5d5d;
            font-size: 15px;
            line-height: 1.8;
        }

        .as-terms-block p:last-child {
            margin-bottom: 0;
        }

        .as-terms-block ul {
            margin: 8px 0 15px;
            padding-left: 22px;
            color: #5d5d5d;
        }

        .as-terms-block li {
            margin-bottom: 9px;
            padding-left: 3px;
            font-size: 15px;
            line-height: 1.65;
        }

        .as-terms-block li::marker {
            color: #dd2476;
        }


        /* =========================================================
           LINKS
        ========================================================= */

        .as-terms-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #dd2476;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .as-terms-link:hover {
            color: #ff512f;
        }

        .as-terms-link i {
            font-size: 12px;
        }


        /* =========================================================
           HIGHLIGHT BOX
        ========================================================= */

        .as-terms-highlight {
            margin-top: 18px;
            padding: 18px 20px;
            border-left: 4px solid #dd2476;
            border-radius: 10px;
            background: #fff6f8;
        }

        .as-terms-highlight p {
            margin: 0;
            color: #555;
            font-size: 14px;
            line-height: 1.7;
        }


        /* =========================================================
           CONTACT / GRIEVANCE
        ========================================================= */

        .as-terms-contact-box {
            margin-top: 18px;
            padding: 24px;
            border-radius: 16px;
            background: linear-gradient(135deg,
                    #fff5f7,
                    #fff9f5);
            border: 1px solid #f2e3e7;
        }

        .as-terms-contact-box p {
            margin-bottom: 8px;
        }

        .as-terms-contact-label {
            font-weight: 700;
            color: #222;
        }


        /* =========================================================
           FINAL CTA
        ========================================================= */

        .as-terms-final {
            margin-top: 55px;
            padding: 55px 30px;
            border-radius: 24px;
            text-align: center;
            color: #fff;
            background: linear-gradient(135deg,
                    #ff512f,
                    #dd2476);
            box-shadow: 0 18px 45px rgba(221, 36, 118, 0.20);
        }

        .as-terms-final h2 {
            margin: 0 0 12px;
            font-size: 30px;
            font-weight: 800;
        }

        .as-terms-final p {
            max-width: 650px;
            margin: 0 auto 24px;
            color: rgba(255, 255, 255, 0.92);
            font-size: 15px;
            line-height: 1.7;
        }

        .as-terms-final-email {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 22px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {

            .as-terms-hero {
                min-height: 390px;
                padding: 95px 6%;
            }

            .as-terms-intro,
            .as-terms-content {
                padding-left: 5%;
                padding-right: 5%;
            }

            .as-terms-block {
                padding: 27px;
            }
        }


        @media (max-width: 650px) {

            .as-terms-hero {
                min-height: 350px;
                padding: 85px 20px 70px;
            }

            .as-terms-hero h1 {
                font-size: 2.15rem;
                letter-spacing: -0.8px;
            }

            .as-terms-hero-description {
                font-size: 15px;
                line-height: 1.65;
            }

            .as-terms-effective {
                font-size: 12px;
            }

            .as-terms-intro {
                padding: 45px 18px 15px;
            }

            .as-terms-content {
                padding: 25px 18px 65px;
            }

            .as-terms-intro-box {
                padding: 22px;
            }

            .as-terms-block {
                padding: 23px 20px;
                border-radius: 17px;
            }

            .as-terms-block-header {
                gap: 12px;
            }

            .as-terms-number {
                width: 35px;
                height: 35px;
                border-radius: 10px;
                font-size: 12px;
            }

            .as-terms-block h2 {
                font-size: 17px;
            }

            .as-terms-block p,
            .as-terms-block li {
                font-size: 14px;
            }

            .as-terms-final {
                padding: 42px 20px;
                border-radius: 20px;
            }

            .as-terms-final h2 {
                font-size: 25px;
            }
        }


        @media (max-width: 380px) {

            .as-terms-hero h1 {
                font-size: 1.9rem;
            }

            .as-terms-block {
                padding: 20px 17px;
            }

            .as-terms-block-header {
                align-items: center;
            }

            .as-terms-number {
                width: 32px;
                height: 32px;
            }
        }
    </style>
@endsection


@section('content')
    <div class="as-terms-page">

        {{-- =====================================================
         HERO
    ====================================================== --}}

        <section class="as-terms-hero">

            <img src="{{ asset('images/coursel.png') }}" class="as-terms-hero-image"
                alt="LGBTQ community celebrating together">

            <div class="as-terms-hero-overlay"></div>

            <div class="as-terms-hero-content">

                <div class="as-terms-eyebrow">
                    <i class="fa-solid fa-file-contract"></i>
                    Legal Information
                </div>

                <h1>Terms &amp; Conditions</h1>

                <p class="as-terms-hero-description">
                    These Terms govern your use of AffirmSpace, including our website
                    and mobile application. Please read them carefully before creating
                    an account or using the Platform.
                </p>

                <div class="as-terms-effective">
                    Effective Date: [DD Month YYYY]
                </div>

            </div>

        </section>


        {{-- =====================================================
         INTRO
    ====================================================== --}}

        <section class="as-terms-intro">

            <div class="as-terms-intro-inner">

                <div class="as-terms-intro-box">

                    <p>
                        These Terms &amp; Conditions ("Terms") govern your use of
                        <strong>Affirm Space</strong> ("AffirmSpace," "we," "us,"
                        or "our"), including our website and mobile application
                        (together, the "Platform").
                    </p>

                    <p style="margin-top:12px;">
                        By creating an account or using AffirmSpace, you agree to
                        these Terms. If you do not agree with them, please do not
                        use the Platform.
                    </p>

                    <p style="margin-top:12px;">
                        <strong>Business location:</strong>
                        Mohali, Punjab, India.
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
         TERMS CONTENT
    ====================================================== --}}

        <section class="as-terms-content">

            <div class="as-terms-container">


                {{-- 1 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">01</div>
                        <h2>Eligibility (18+ Only)</h2>
                    </div>

                    <p>
                        AffirmSpace is strictly for users aged 18 or older.
                        By using the Platform, you confirm that you meet this
                        requirement.
                    </p>

                    <p>
                        Accounts found to be underage may be removed without notice.
                    </p>

                </article>


                {{-- 2 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">02</div>
                        <h2>User Accounts</h2>
                    </div>

                    <p>
                        You are responsible for maintaining the confidentiality
                        of your account credentials and for activity carried out
                        through your account.
                    </p>

                    <p>
                        You should take reasonable steps to protect your account
                        information and notify AffirmSpace if you believe your
                        account has been accessed without authorization.
                    </p>

                </article>


                {{-- 3 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">03</div>
                        <h2>Community Guidelines</h2>
                    </div>

                    <p>
                        AffirmSpace is intended to provide an inclusive and
                        respectful environment. Users must not use the Platform
                        for:
                    </p>

                    <ul>
                        <li>Harassment, abuse, threats, or hate speech.</li>
                        <li>Discrimination based on identity or personal characteristics.</li>
                        <li>Illegal, harmful, or abusive content or activity.</li>
                        <li>Impersonation, fraud, deception, or misleading conduct.</li>
                    </ul>

                    <p>
                        Additional rules and safety expectations are set out in
                        our Community Guidelines.
                    </p>

                    <a href="{{ route('community') }}" class="as-terms-link">
                        View Community Guidelines
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </article>


                {{-- 4 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">04</div>
                        <h2>Counselling Disclaimer</h2>
                    </div>

                    <p>
                        Counselling services available through AffirmSpace are
                        supportive in nature and do not guarantee any particular
                        outcome.
                    </p>

                    <p>
                        AffirmSpace is not a substitute for medical or psychiatric
                        treatment. The Platform is not intended for emergency
                        situations.
                    </p>

                    <p>
                        Counselling professionals available through AffirmSpace
                        may provide professional guidance within the scope of
                        their qualifications and relationship with the user.
                    </p>

                    <div class="as-terms-highlight">
                        <p>
                            <strong>Important:</strong>
                            If you are experiencing an emergency or believe that
                            you or someone else is in immediate danger, contact
                            appropriate emergency or crisis services rather than
                            relying on AffirmSpace.
                        </p>
                    </div>

                    <p style="margin-top:18px;">
                        The exact professional relationship between AffirmSpace
                        and individual counsellors is subject to the applicable
                        counselling arrangement.
                    </p>

                </article>


                {{-- 5 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">05</div>
                        <h2>Safety and In-Person Interactions</h2>
                    </div>

                    <p>
                        AffirmSpace does not represent that it conducts background
                        checks on users.
                    </p>

                    <p>
                        You are responsible for exercising appropriate judgment
                        when communicating with other users and when deciding
                        whether to meet someone in person.
                    </p>

                    <p>
                        AffirmSpace is not responsible for the conduct of users
                        on or off the Platform or for in-person meetings arranged
                        through the Platform.
                    </p>

                    <p>
                        Please review available safety guidance before arranging
                        an in-person meeting.
                    </p>

                </article>


                {{-- 6 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">06</div>
                        <h2>Payments</h2>
                    </div>

                    <p>
                        Paid services must be completed through payment methods
                        approved or made available by AffirmSpace.
                    </p>

                    <p>
                        By making a payment, you agree to the applicable pricing,
                        payment and billing terms displayed at the time of purchase.
                    </p>

                    <p>
                        Where a third-party payment provider is used, the
                        provider's applicable terms and policies may also apply
                        to the payment transaction.
                    </p>

                    {{-- Keep automatic-renewal wording out until confirmed. --}}

                </article>


                {{-- 7 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">07</div>
                        <h2>Refund Policy</h2>
                    </div>

                    <p>
                        Refunds are handled according to AffirmSpace's official
                        Refund Policy and any rights available to users under
                        applicable law.
                    </p>

                    <a href="{{ route('refundPolicy') }}" class="as-terms-link">
                        View Refund Policy
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </article>


                {{-- 8 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">08</div>
                        <h2>User Content</h2>
                    </div>

                    <p>
                        You are responsible for all content you post, upload,
                        transmit, or otherwise make available through the Platform.
                    </p>

                    <p>
                        You must ensure that your content does not violate these
                        Terms, applicable law, the rights of others, or our
                        Community Guidelines.
                    </p>

                    <p>
                        By posting content on AffirmSpace, you grant AffirmSpace
                        a non-exclusive, worldwide, royalty-free license to host,
                        display, reproduce, and distribute that content solely as
                        reasonably necessary to operate and provide the Platform's
                        services to you and other users.
                    </p>

                    <p>
                        AffirmSpace may remove, restrict, or disable access to
                        content that violates these Terms, applicable policies,
                        or Community Guidelines.
                    </p>

                </article>


                {{-- 9 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">09</div>
                        <h2>Intellectual Property</h2>
                    </div>

                    <p>
                        The AffirmSpace name, logo, website, mobile application,
                        original platform content, branding, design elements,
                        software, and other materials created by AffirmSpace
                        are owned by or licensed to AffirmSpace, except for
                        user-generated content.
                    </p>

                    <p>
                        You may not copy, reproduce, modify, distribute, sell,
                        or otherwise use AffirmSpace intellectual property without
                        appropriate authorization.
                    </p>

                    <p>
                        If you believe material available on the Platform
                        infringes your intellectual property rights, please
                        contact us with sufficient details regarding the alleged
                        infringement.
                    </p>

                    <div class="as-terms-contact-box">

                        <p>
                            <span class="as-terms-contact-label">
                                Intellectual Property Contact:
                            </span>
                        </p>

                        <p>
                            <a href="mailto:info@affirmspace.com" class="as-terms-link">
                                info@affirmspace.com
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </p>

                    </div>

                </article>


                {{-- 10 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">10</div>
                        <h2>Account Suspension and Termination</h2>
                    </div>

                    <p>
                        AffirmSpace reserves the right to suspend, restrict, or
                        terminate an account where there is a violation of these
                        Terms, Community Guidelines, applicable law, or misuse
                        of the Platform.
                    </p>

                    <p>
                        You may terminate your relationship with AffirmSpace at
                        any time by deleting your account, subject to any applicable
                        obligations that survive termination.
                    </p>

                    <p>
                        For instructions on deleting your account, please refer
                        to the Account Deletion page.
                    </p>

                    <a href="{{ url('/account-deletion') }}" class="as-terms-link">
                        Account Deletion Instructions
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </article>


                {{-- 11 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">11</div>
                        <h2>Disclaimer of Warranties</h2>
                    </div>

                    <p>
                        The Platform is provided on an "as is" and "as available"
                        basis, to the maximum extent permitted by applicable law.
                    </p>

                    <p>
                        AffirmSpace does not guarantee that the Platform will
                        always be available, uninterrupted, error-free, accurate,
                        or completely secure.
                    </p>

                    <p>
                        To the extent permitted by applicable law, AffirmSpace
                        disclaims warranties that cannot be reasonably guaranteed,
                        including implied warranties relating to fitness for a
                        particular purpose or uninterrupted availability.
                    </p>

                </article>


                {{-- 12 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">12</div>
                        <h2>Limitation of Liability</h2>
                    </div>

                    <p>
                        To the maximum extent permitted by applicable law,
                        AffirmSpace is not responsible for user interactions,
                        disputes between users, meetings arranged between users,
                        or outcomes arising from interactions between users.
                    </p>

                    <p>
                        To the maximum extent permitted by law, AffirmSpace's
                        liability for claims arising from or relating to your
                        use of the Platform will be limited to the extent
                        permitted under applicable law.
                    </p>

                </article>


                {{-- 13 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">13</div>
                        <h2>Indemnification</h2>
                    </div>

                    <p>
                        To the extent permitted by applicable law, you agree to
                        indemnify and hold AffirmSpace harmless from claims,
                        damages, liabilities, losses, and reasonable expenses
                        arising from your use of the Platform, your content,
                        your violation of these Terms, or your violation of
                        another person's rights.
                    </p>

                </article>


                {{-- 14 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">14</div>
                        <h2>Privacy</h2>
                    </div>

                    <p>
                        Your personal information is handled according to the
                        AffirmSpace Privacy Policy.
                    </p>

                    <a href="{{ route('privacy') }}" class="as-terms-link">
                        View Privacy Policy
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </article>


                {{-- 15 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">15</div>
                        <h2>Force Majeure</h2>
                    </div>

                    <p>
                        AffirmSpace is not liable for a failure or delay in
                        performing its obligations where the failure or delay
                        results from circumstances beyond its reasonable control,
                        including significant outages, natural disasters,
                        infrastructure failures, governmental actions, or other
                        unforeseeable events.
                    </p>

                </article>


                {{-- 16 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">16</div>
                        <h2>Changes to These Terms</h2>
                    </div>

                    <p>
                        We may update these Terms from time to time to reflect
                        changes to the Platform, our practices, or applicable
                        legal requirements.
                    </p>

                    <p>
                        Material changes may be communicated through the Platform,
                        app, email, or by updating the Effective Date displayed
                        on this page, as appropriate.
                    </p>

                </article>


                {{-- 17 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">17</div>
                        <h2>Assignment</h2>
                    </div>

                    <p>
                        AffirmSpace may assign or transfer these Terms, in whole
                        or in part, where reasonably necessary for business
                        operations, restructuring, financing, merger, acquisition,
                        sale, or transfer of the Platform, subject to applicable law.
                    </p>

                    <p>
                        You may not assign or transfer your rights or obligations
                        under these Terms without our prior written consent,
                        except where applicable law provides otherwise.
                    </p>

                </article>


                {{-- 18 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">18</div>
                        <h2>Severability</h2>
                    </div>

                    <p>
                        If any provision of these Terms is found to be invalid,
                        unlawful, or unenforceable, the remaining provisions
                        will continue in full force and effect to the extent
                        permitted by law.
                    </p>

                </article>


                {{-- 19 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">19</div>
                        <h2>Entire Agreement</h2>
                    </div>

                    <p>
                        These Terms, together with the Privacy Policy, Refund
                        Policy, Community Guidelines, and other policies expressly
                        incorporated into these Terms, constitute the agreement
                        governing your use of the Platform.
                    </p>

                </article>


                {{-- 20 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">20</div>
                        <h2>Governing Law and Jurisdiction</h2>
                    </div>

                    <p>
                        These Terms are governed by the laws of India.
                    </p>

                    <div class="as-terms-highlight">
                        <p>
                            <strong>Jurisdiction:</strong>
                            These Terms are governed by and interpreted in accordance with the laws of India.
                        </p>
                    </div>

                    <p style="margin-top:18px;">
                        Subject to applicable law, disputes arising out of or relating to these Terms or your use of the
                        Platform shall be subject to the jurisdiction of the courts having appropriate jurisdiction over the
                        location of Affirm Space's business/enterprise in Mohali, Punjab, India. </p>

                </article>


                {{-- 21 --}}
                <article class="as-terms-block">

                    <div class="as-terms-block-header">
                        <div class="as-terms-number">21</div>
                        <h2>Grievance Officer</h2>
                    </div>

                    <p>
                        In accordance with applicable law, AffirmSpace maintains
                        a grievance contact for complaints relating to the
                        Platform, these Terms, or related policies.
                    </p>

                    <p>
                        Complaints will be handled in accordance with the
                        applicable legal requirements and AffirmSpace's internal
                        grievance process.
                    </p>

                    <div class="as-terms-contact-box">

                        <p>
                            <span class="as-terms-contact-label">
                                Grievance Officer:
                            </span>
                            AffirmSpace Support Team
                        </p>

                        <p>
                            <span class="as-terms-contact-label">
                                Email:
                            </span>

                            <a href="mailto:info@affirmspace.com" class="as-terms-link">
                                info@affirmspace.com
                            </a>
                        </p>

                        <p>
                            <span class="as-terms-contact-label">
                                Business Location:
                            </span>
                            Mohali, Punjab, India
                        </p>

                    </div>

                </article>


                {{-- FINAL --}}
                <div class="as-terms-final">

                    <h2>Questions About These Terms?</h2>

                    <p>
                        If you have questions about these Terms, your account,
                        payments, privacy, or how AffirmSpace works, contact our
                        support team.
                    </p>

                    <a href="mailto:info@affirmspace.com" class="as-terms-final-email">

                        <i class="fa-solid fa-envelope"></i>

                        info@affirmspace.com

                    </a>

                </div>


            </div>

        </section>

    </div>
@endsection
