@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Report a Problem – AffirmSpace</title>

    <meta name="description"
        content="Report technical issues, account problems, payment issues, harassment, fake profiles, inappropriate content, or other safety concerns to AffirmSpace.">

    <meta name="author" content="AffirmSpace">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection


@section('css')
    <style>
        /* =========================================================
           AFFIRMSPACE — REPORT A PROBLEM
           Scoped styles only
        ========================================================= */

        .as-report-page {
            font-family: 'Inter', sans-serif;
            color: #222;
            background: #fff;
        }

        .as-report-page *,
        .as-report-page *::before,
        .as-report-page *::after {
            box-sizing: border-box;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .as-report-hero {
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

        .as-report-hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .as-report-hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg,
                    rgba(255, 81, 47, 0.70),
                    rgba(221, 36, 118, 0.73)),
                rgba(0, 0, 0, 0.42);
            z-index: 1;
        }

        .as-report-hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
        }

        .as-report-eyebrow {
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

        .as-report-eyebrow i {
            font-size: 13px;
        }

        .as-report-hero h1 {
            margin: 0 0 18px;
            font-size: clamp(2.2rem, 5vw, 4rem);
            line-height: 1.08;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .as-report-hero-description {
            max-width: 720px;
            margin: 0 auto;
            color: rgba(255, 255, 255, 0.93);
            font-size: 17px;
            line-height: 1.75;
        }


        /* =========================================================
           INTRO
        ========================================================= */

        .as-report-intro {
            padding: 75px 7% 30px;
            background: #fff;
        }

        .as-report-container {
            max-width: 1050px;
            margin: 0 auto;
        }

        .as-report-intro-box {
            position: relative;
            padding: 30px 34px;
            border: 1px solid #f1e3e8;
            border-radius: 20px;
            background: linear-gradient(135deg,
                    #fff7f9,
                    #fff);
            box-shadow: 0 10px 35px rgba(221, 36, 118, 0.06);
            overflow: hidden;
        }

        .as-report-intro-box::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg,
                    #ff512f,
                    #dd2476);
        }

        .as-report-intro-box p {
            margin: 0;
            color: #555;
            font-size: 15px;
            line-height: 1.8;
        }


        /* =========================================================
           WHAT YOU CAN REPORT
        ========================================================= */

        .as-report-content {
            padding: 35px 7% 100px;
            background: #fff;
        }

        .as-report-section-heading {
            margin-bottom: 25px;
        }

        .as-report-section-heading h2 {
            margin: 0 0 9px;
            color: #181818;
            font-size: 27px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -0.4px;
        }

        .as-report-section-heading p {
            margin: 0;
            color: #707070;
            font-size: 14px;
            line-height: 1.7;
        }

        .as-report-type-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
            margin-bottom: 65px;
        }

        .as-report-type-card {
            padding: 30px;
            border: 1px solid #eeeeee;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.045);
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }

        .as-report-type-card:hover {
            transform: translateY(-3px);
            border-color: rgba(221, 36, 118, 0.16);
            box-shadow: 0 14px 38px rgba(221, 36, 118, 0.07);
        }

        .as-report-type-icon {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            border-radius: 13px;
            background: #fff1f5;
            color: #dd2476;
            font-size: 18px;
        }

        .as-report-type-card h3 {
            margin: 0 0 15px;
            color: #191919;
            font-size: 19px;
            font-weight: 750;
        }

        .as-report-type-card ul {
            margin: 0;
            padding-left: 20px;
            color: #5e5e5e;
        }

        .as-report-type-card li {
            margin-bottom: 9px;
            padding-left: 3px;
            font-size: 14px;
            line-height: 1.6;
        }

        .as-report-type-card li:last-child {
            margin-bottom: 0;
        }

        .as-report-type-card li::marker {
            color: #dd2476;
        }


        /* =========================================================
           HOW TO REPORT
        ========================================================= */

        .as-report-form-section {
            display: grid;
            grid-template-columns: minmax(0, 0.85fr) minmax(0, 1.15fr);
            gap: 35px;
            align-items: start;
            margin-bottom: 65px;
        }

        .as-report-instructions {
            padding: 30px;
            border-radius: 20px;
            background: #fafafa;
            border: 1px solid #eeeeee;
        }

        .as-report-instructions h2 {
            margin: 0 0 13px;
            color: #191919;
            font-size: 22px;
            font-weight: 800;
        }

        .as-report-instructions>p {
            margin: 0 0 22px;
            color: #626262;
            font-size: 14px;
            line-height: 1.75;
        }

        .as-report-check-list {
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .as-report-check-item {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 13px 14px;
            border: 1px solid #eeeeee;
            border-radius: 12px;
            background: #fff;
            color: #555;
            font-size: 13px;
            line-height: 1.55;
        }

        .as-report-check-item i {
            flex-shrink: 0;
            margin-top: 3px;
            color: #dd2476;
            font-size: 12px;
        }


        /* =========================================================
           REPORT FORM
        ========================================================= */

        .as-report-form-card {
            padding: 32px;
            border: 1px solid #eeeeee;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.055);
        }

        .as-report-form-card h2 {
            margin: 0 0 8px;
            color: #191919;
            font-size: 23px;
            font-weight: 800;
        }

        .as-report-form-card>p {
            margin: 0 0 24px;
            color: #777;
            font-size: 13px;
            line-height: 1.65;
        }

        .as-report-form-group {
            margin-bottom: 17px;
        }

        .as-report-form-group label {
            display: block;
            margin-bottom: 7px;
            color: #333;
            font-size: 13px;
            font-weight: 700;
        }

        .as-report-form-group input,
        .as-report-form-group textarea {
            width: 100%;
            border: 1px solid #dddddd;
            border-radius: 12px;
            background: #fff;
            color: #222;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .as-report-form-group input {
            min-height: 49px;
            padding: 13px 15px;
        }

        .as-report-form-group textarea {
            min-height: 155px;
            padding: 13px 15px;
            resize: vertical;
        }

        .as-report-form-group input:focus,
        .as-report-form-group textarea:focus {
            border-color: #dd2476;
            box-shadow: 0 0 0 4px rgba(221, 36, 118, 0.08);
        }

        .as-report-form-group input::placeholder,
        .as-report-form-group textarea::placeholder {
            color: #aaa;
        }

        .as-report-submit {
            width: 100%;
            min-height: 51px;
            margin-top: 4px;
            border: 0;
            border-radius: 13px;
            background: linear-gradient(90deg,
                    #ff512f,
                    #dd2476);
            color: #fff;
            font-family: inherit;
            font-size: 14px;
            font-weight: 750;
            cursor: pointer;
            box-shadow: 0 9px 24px rgba(221, 36, 118, 0.18);
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .as-report-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 13px 30px rgba(221, 36, 118, 0.23);
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .as-report-alert {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.6;
        }

        .as-report-alert-success {
            border: 1px solid #ccebd9;
            background: #f1fbf5;
            color: #24643e;
        }

        .as-report-alert-error {
            border: 1px solid #f0cccc;
            background: #fff5f5;
            color: #8b3030;
        }


        /* =========================================================
           WHAT HAPPENS NEXT
        ========================================================= */

        .as-report-next {
            margin-bottom: 65px;
        }

        .as-report-next-box {
            padding: 30px 32px;
            border-radius: 20px;
            border: 1px solid #eeeeee;
            background: linear-gradient(135deg,
                    #fff,
                    #fff9fb);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        }

        .as-report-next-box p {
            margin: 0;
            color: #5e5e5e;
            font-size: 14px;
            line-height: 1.8;
        }

        .as-report-next-points {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 13px;
            margin-top: 22px;
        }

        .as-report-next-point {
            padding: 16px;
            border-radius: 13px;
            background: #fff;
            border: 1px solid #eeeeee;
        }

        .as-report-next-point i {
            display: block;
            margin-bottom: 9px;
            color: #dd2476;
        }

        .as-report-next-point span {
            color: #555;
            font-size: 13px;
            line-height: 1.55;
        }


        /* =========================================================
           URGENT
        ========================================================= */

        .as-report-urgent {
            display: flex;
            align-items: flex-start;
            gap: 17px;
            margin-bottom: 55px;
            padding: 25px 27px;
            border: 1px solid #f1dcdc;
            border-radius: 18px;
            background: #fff8f8;
        }

        .as-report-urgent-icon {
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(135deg,
                    #ff512f,
                    #dd2476);
            color: #fff;
        }

        .as-report-urgent h3 {
            margin: 1px 0 7px;
            color: #222;
            font-size: 16px;
            font-weight: 750;
        }

        .as-report-urgent p {
            margin: 0;
            color: #606060;
            font-size: 14px;
            line-height: 1.75;
        }


        /* =========================================================
           FINAL CTA
        ========================================================= */

        .as-report-help {
            padding: 55px 30px;
            border-radius: 24px;
            text-align: center;
            color: #fff;
            background: linear-gradient(135deg,
                    #ff512f,
                    #dd2476);
            box-shadow: 0 18px 45px rgba(221, 36, 118, 0.20);
        }

        .as-report-help-icon {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 17px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 20px;
        }

        .as-report-help h2 {
            margin: 0 0 11px;
            font-size: 30px;
            font-weight: 800;
        }

        .as-report-help p {
            max-width: 620px;
            margin: 0 auto 23px;
            color: rgba(255, 255, 255, 0.92);
            font-size: 15px;
            line-height: 1.7;
        }

        .as-report-email {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 23px;
            border-radius: 50px;
            background: #fff;
            color: #dd2476;
            font-size: 14px;
            font-weight: 750;
            text-decoration: none;
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .as-report-email:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.15);
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {

            .as-report-hero {
                min-height: 390px;
                padding: 95px 6%;
            }

            .as-report-intro,
            .as-report-content {
                padding-left: 5%;
                padding-right: 5%;
            }

            .as-report-form-section {
                grid-template-columns: 1fr;
            }

            .as-report-next-points {
                grid-template-columns: 1fr;
            }
        }


        @media (max-width: 650px) {

            .as-report-hero {
                min-height: 360px;
                padding: 85px 20px 70px;
            }

            .as-report-hero h1 {
                font-size: 2.15rem;
                letter-spacing: -0.8px;
            }

            .as-report-hero-description {
                font-size: 15px;
                line-height: 1.65;
            }

            .as-report-intro {
                padding: 45px 18px 20px;
            }

            .as-report-content {
                padding: 25px 18px 70px;
            }

            .as-report-intro-box {
                padding: 24px 22px;
            }

            .as-report-type-grid {
                grid-template-columns: 1fr;
            }

            .as-report-type-card {
                padding: 25px 22px;
            }

            .as-report-instructions {
                padding: 25px 22px;
            }

            .as-report-form-card {
                padding: 25px 20px;
            }

            .as-report-urgent {
                padding: 21px;
            }

            .as-report-help {
                padding: 43px 20px;
                border-radius: 20px;
            }

            .as-report-help h2 {
                font-size: 25px;
            }
        }


        @media (max-width: 380px) {

            .as-report-hero h1 {
                font-size: 1.9rem;
            }

            .as-report-urgent {
                flex-direction: column;
            }
        }
    </style>
@endsection


@section('content')
    <div class="as-report-page">


        {{-- =====================================================
         HERO
    ====================================================== --}}

        <section class="as-report-hero">

            <img src="{{ asset('images/coursel.png') }}" class="as-report-hero-image"
                alt="LGBTQ community celebrating together">

            <div class="as-report-hero-overlay"></div>

            <div class="as-report-hero-content">

                <div class="as-report-eyebrow">
                    <i class="fa-solid fa-flag"></i>
                    Help &amp; Safety
                </div>

                <h1>Report a Problem</h1>

                <p class="as-report-hero-description">
                    If something isn't working right, or you've come across
                    behavior that doesn't belong on AffirmSpace, let us know.
                    This page covers both technical issues and safety concerns.
                </p>

            </div>

        </section>


        {{-- =====================================================
         INTRO
    ====================================================== --}}

        <section class="as-report-intro">

            <div class="as-report-container">

                <div class="as-report-intro-box">

                    <p>
                        Whether you've found a technical bug, are having trouble
                        accessing your account, or need to report something
                        involving another user, you can use the form below to
                        send us a report.
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
         CONTENT
    ====================================================== --}}

        <section class="as-report-content">

            <div class="as-report-container">


                {{-- =================================================
                 WHAT YOU CAN REPORT
            ================================================== --}}

                <div class="as-report-section-heading">

                    <h2>What You Can Report</h2>

                    <p>
                        You can use this page for both technical problems and
                        safety or behavior concerns.
                    </p>

                </div>


                <div class="as-report-type-grid">


                    {{-- TECHNICAL --}}

                    <div class="as-report-type-card">

                        <div class="as-report-type-icon">
                            <i class="fa-solid fa-bug"></i>
                        </div>

                        <h3>Technical Issues</h3>

                        <ul>

                            <li>App crashes or bugs</li>

                            <li>
                                Features not working as expected
                            </li>

                            <li>
                                Payment or billing issues
                            </li>

                            <li>
                                Login or account access problems
                            </li>

                        </ul>

                    </div>


                    {{-- SAFETY --}}

                    <div class="as-report-type-card">

                        <div class="as-report-type-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>

                        <h3>Safety &amp; Behavior Issues</h3>

                        <ul>

                            <li>
                                Harassment, abuse, or hate speech
                            </li>

                            <li>
                                Fake profiles or impersonation
                            </li>

                            <li>
                                Inappropriate content or photos
                            </li>

                            <li>
                                Any behavior that violates our
                                Community Guidelines
                            </li>

                        </ul>

                    </div>

                </div>


                {{-- =================================================
                 HOW TO REPORT + FORM
            ================================================== --}}

                <div class="as-report-form-section">


                    {{-- INSTRUCTIONS --}}

                    <div class="as-report-instructions">

                        <h2>How to Report</h2>

                        <p>
                            Use the contact form to send us your report.
                            Since the form doesn't have separate fields for every
                            detail, please include as much of the following as
                            you can in your message.
                        </p>


                        <div class="as-report-check-list">

                            <div class="as-report-check-item">

                                <i class="fa-solid fa-check"></i>

                                <span>
                                    <strong>What happened</strong> —
                                    a short description of the issue.
                                </span>

                            </div>


                            <div class="as-report-check-item">

                                <i class="fa-solid fa-check"></i>

                                <span>
                                    <strong>Other user</strong> —
                                    their username or profile, if possible.
                                </span>

                            </div>


                            <div class="as-report-check-item">

                                <i class="fa-solid fa-check"></i>

                                <span>
                                    <strong>When it happened</strong> —
                                    include the approximate date or time.
                                </span>

                            </div>


                            <div class="as-report-check-item">

                                <i class="fa-solid fa-check"></i>

                                <span>
                                    <strong>Screenshots</strong> —
                                    include them if available.
                                </span>

                            </div>


                            <div class="as-report-check-item">

                                <i class="fa-solid fa-envelope"></i>

                                <span>
                                    If the form doesn't support attachments,
                                    screenshots can also be emailed to
                                    <strong>info@affirmspace.com</strong>.
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- FORM --}}

                    <div class="as-report-form-card">

                        <h2>Send Us a Report</h2>

                        <p>
                            Please provide as much detail as possible so our team
                            can understand and review the issue.
                        </p>


                        @if (session('success'))
                            <div class="as-report-alert as-report-alert-success">
                                {{ session('success') }}
                            </div>
                        @endif


                        @if (session('error'))
                            <div class="as-report-alert as-report-alert-error">
                                {{ session('error') }}
                            </div>
                        @endif


                        <form method="POST" action="{{ route('AdminSend') }}">

                            @csrf


                            {{-- FULL NAME --}}

                            <div class="as-report-form-group">

                                <label for="report_name">
                                    Full Name
                                </label>

                                <input type="text" id="report_name" name="name" placeholder="Your name"
                                    value="{{ old('name') }}" required>

                                @error('name')
                                    <small class="as-field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- EMAIL --}}

                            <div class="as-report-form-group">

                                <label for="report_email">
                                    Email Address
                                </label>

                                <input type="email" id="report_email" name="email" placeholder="Your email address"
                                    value="{{ old('email') }}" required>

                                @error('email')
                                    <small class="as-field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- SUBJECT --}}

                            <div class="as-report-form-group">

                                <label for="report_subject">
                                    Subject
                                </label>

                                <input type="text" id="report_subject" name="subject"
                                    placeholder='e.g. "App bug" or "Reporting a user"' value="{{ old('subject') }}"
                                    required>

                                @error('subject')
                                    <small class="as-field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- MESSAGE --}}

                            <div class="as-report-form-group">

                                <label for="report_message">
                                    Message
                                </label>

                                <textarea id="report_message" name="message"
                                    placeholder="Please describe what happened, when it happened, and any relevant username or profile information."
                                    required>{{ old('message') }}</textarea>

                                @error('message')
                                    <small class="as-field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            <button type="submit" class="as-report-submit">

                                <i class="fa-solid fa-paper-plane"></i>
                                &nbsp; Send Report

                            </button>

                        </form>

                    </div>

                </div>


                {{-- =================================================
                 WHAT HAPPENS NEXT
            ================================================== --}}

                <div class="as-report-next">

                    <div class="as-report-section-heading">

                        <h2>What Happens Next</h2>

                        <p>
                            We review every report that comes in.
                        </p>

                    </div>


                    <div class="as-report-next-box">

                        <p>
                            Our team reviews every report that comes in.
                            Depending on what's reported, this may mean fixing
                            a technical issue or reviewing and taking action
                            against an account that violates our guidelines.
                        </p>


                        <div class="as-report-next-points">

                            <div class="as-report-next-point">

                                <i class="fa-solid fa-wrench"></i>

                                <span>
                                    Technical issues may be investigated
                                    and addressed by our team.
                                </span>

                            </div>


                            <div class="as-report-next-point">

                                <i class="fa-solid fa-file-circle-check"></i>

                                <span>
                                    Reports involving users or content may
                                    be reviewed against our guidelines.
                                </span>

                            </div>


                            <div class="as-report-next-point">

                                <i class="fa-solid fa-user-shield"></i>

                                <span>
                                    Depending on the circumstances, action may
                                    include warnings, content removal, or
                                    account suspension.
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                 URGENT
            ================================================== --}}

                <div class="as-report-urgent">

                    <div class="as-report-urgent-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <div>

                        <h3>If It's Urgent</h3>

                        <p>
                            If you're reporting something involving child safety
                            or immediate harm, please see the Child Safety
                            Standards section in the Privacy Policy for how to
                            report it directly. If there is any immediate danger,
                            please contact local authorities first.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                 FINAL HELP
            ================================================== --}}

                <div class="as-report-help">

                    <div class="as-report-help-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>

                    <h2>We're Here to Help</h2>

                    <p>
                        We aim to respond to every message as quickly as we can.
                        If you need help with a report or have a question before
                        submitting one, contact us directly.
                    </p>

                    <a href="mailto:info@affirmspace.com" class="as-report-email">

                        <i class="fa-solid fa-envelope"></i>

                        info@affirmspace.com

                    </a>

                </div>


            </div>

        </section>

    </div>
@endsection
