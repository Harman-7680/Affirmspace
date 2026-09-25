@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Contact AffirmSpace for help with our LGBTQ+ platform, community, dating, chat, and counselling support services.">

    <meta name="robots" content="index, follow">

    <meta name="author" content="AffirmSpace">

    <title>Contact AffirmSpace – LGBTQ+ Support & Help Center</title>

    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        .as-contact-page {

            --as-orange: #ff512f;
            --as-pink: #dd2476;
            --as-gradient: linear-gradient(90deg, #ff512f, #dd2476);

            font-family: 'Inter', sans-serif;

            color: #222;

            background: #fff;

            overflow: hidden;

        }


        .as-contact-page *,
        .as-contact-page *::before,
        .as-contact-page *::after {

            box-sizing: border-box;

        }


        .as-contact-container {

            width: min(1180px, calc(100% - 40px));

            margin: 0 auto;

        }


        /* =========================================================
                               ALERTS
                            ========================================================= */

        .as-contact-alert {

            position: fixed;

            top: 25px;

            left: 50%;

            transform: translateX(-50%);

            z-index: 99999;

            min-width: 300px;

            max-width: calc(100% - 30px);

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            padding: 14px 20px;

            border-radius: 12px;

            font-size: 14px;

            font-weight: 600;

            text-align: center;

            box-shadow: 0 12px 35px rgba(0, 0, 0, .15);

        }


        .as-contact-success {

            background: #dcfce7;

            border: 1px solid #22c55e;

            color: #166534;

        }


        .as-contact-error {

            background: #fee2e2;

            border: 1px solid #ef4444;

            color: #991b1b;

        }


        .as-alert-icon {

            width: 25px;

            height: 25px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            border-radius: 50%;

            background: rgba(255, 255, 255, .7);

            font-weight: 800;

        }


        /* =========================================================
                               HERO
                            ========================================================= */

        .as-contact-hero {

            position: relative;

            min-height: 500px;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 100px 20px;

            text-align: center;

            color: #fff;

            overflow: hidden;

            isolation: isolate;

        }


        .as-contact-hero-image {

            position: absolute;

            inset: 0;

            width: 100%;

            height: 100%;

            object-fit: cover;

            object-position: center;

            z-index: -3;

        }


        .as-contact-hero::before {

            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(135deg,
                    rgba(0, 0, 0, .70),
                    rgba(0, 0, 0, .52));

            z-index: -2;

        }


        .as-contact-hero::after {

            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(90deg,
                    rgba(255, 81, 47, .18),
                    rgba(221, 36, 118, .18));

            mix-blend-mode: screen;

            z-index: -1;

            pointer-events: none;

        }


        .as-contact-hero-content {

            position: relative;

            z-index: 2;

            width: 100%;

            max-width: 850px;

            margin: 0 auto;

        }


        .as-contact-badge {

            display: inline-flex;

            align-items: center;

            gap: 9px;

            padding: 9px 17px;

            margin-bottom: 22px;

            border: 1px solid rgba(255, 255, 255, .28);

            border-radius: 50px;

            background: rgba(255, 255, 255, .10);

            backdrop-filter: blur(8px);

            color: #fff;

            font-size: 12px;

            font-weight: 700;

            letter-spacing: .4px;

        }


        .as-badge-dot {

            width: 8px;

            height: 8px;

            border-radius: 50%;

            background: linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            box-shadow:
                0 0 0 4px rgba(255, 255, 255, .12);

        }


        .as-contact-hero h1 {

            margin: 0 0 20px;

            color: #fff;

            font-size: clamp(42px, 6vw, 68px);

            line-height: 1.05;

            font-weight: 800;

            letter-spacing: -2.5px;

        }


        .as-contact-hero h1 span {

            background: linear-gradient(90deg,
                    #ff8a70,
                    #ff76ac);

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;

            background-clip: text;

        }


        .as-contact-hero-description {

            max-width: 720px;

            margin: 0 auto;

            color: rgba(255, 255, 255, .92);

            font-size: 18px;

            line-height: 1.75;

        }


        .as-contact-hero-subline {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 14px;

            margin-top: 28px;

            color: rgba(255, 255, 255, .78);

            font-size: 13px;

            font-weight: 600;

        }


        .as-contact-hero-subline span {

            width: 45px;

            height: 1px;

            background: rgba(255, 255, 255, .35);

        }


        /* =========================================================
                               CONTACT MAIN
                            ========================================================= */

        .as-contact-main {

            padding: 100px 0 110px;

            background: #fff;

        }


        .as-contact-layout {

            display: grid;

            grid-template-columns: minmax(0, .9fr) minmax(420px, 1.1fr);

            gap: 70px;

            align-items: start;

        }


        /* =========================================================
                               INFORMATION SIDE
                            ========================================================= */

        .as-contact-info {

            padding-top: 10px;

        }


        .as-section-label {

            display: inline-block;

            margin-bottom: 13px;

            color: #dd2476;

            font-size: 12px;

            font-weight: 800;

            letter-spacing: 1.5px;

        }


        .as-contact-info h2 {

            margin: 0 0 18px;

            color: #1c1c1c;

            font-size: 42px;

            line-height: 1.13;

            font-weight: 800;

            letter-spacing: -1.3px;

        }


        .as-contact-info h2 span {

            background: var(--as-gradient);

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;

            background-clip: text;

        }


        .as-contact-intro {

            max-width: 570px;

            margin: 0 0 38px;

            color: #666;

            font-size: 15.5px;

            line-height: 1.8;

        }


        /* =========================================================
                               HELP CARDS
                            ========================================================= */

        .as-help-list {

            display: flex;

            flex-direction: column;

            border-top: 1px solid #eeeeee;

        }


        .as-help-card {

            display: flex;

            align-items: flex-start;

            gap: 16px;

            padding: 19px 0;

            border-bottom: 1px solid #eeeeee;

        }


        .as-help-icon {

            width: 45px;

            height: 45px;

            flex: 0 0 45px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 13px;

            background: #fff2f5;

            color: #dd2476;

            font-size: 18px;

        }


        .as-help-card h3 {

            margin: 1px 0 5px;

            color: #242424;

            font-size: 15px;

            line-height: 1.4;

            font-weight: 750;

        }


        .as-help-card p {

            margin: 0;

            color: #707070;

            font-size: 13.5px;

            line-height: 1.65;

        }


        /* =========================================================
                               RESPONSE NOTE
                            ========================================================= */

        .as-response-note {

            display: flex;

            align-items: flex-start;

            gap: 13px;

            margin-top: 28px;

            padding: 18px;

            border: 1px solid rgba(221, 36, 118, .11);

            border-radius: 16px;

            background:
                linear-gradient(90deg,
                    rgba(255, 81, 47, .05),
                    rgba(221, 36, 118, .05));

        }


        .as-response-icon {

            width: 36px;

            height: 36px;

            flex: 0 0 36px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: var(--as-gradient);

            color: #fff;

            font-size: 15px;

            font-weight: 800;

        }


        .as-response-note strong {

            display: block;

            margin-bottom: 3px;

            color: #333;

            font-size: 14px;

        }


        .as-response-note p {

            margin: 0;

            color: #666;

            font-size: 13px;

            line-height: 1.6;

        }


        /* =========================================================
                               FORM CARD
                            ========================================================= */

        .as-contact-form-card {

            padding: 36px;

            background: #fff;

            border: 1px solid #eeeeee;

            border-radius: 25px;

            box-shadow:
                0 25px 70px rgba(0, 0, 0, .08),
                0 5px 20px rgba(221, 36, 118, .035);

        }


        .as-form-header {

            display: flex;

            align-items: center;

            gap: 15px;

            padding-bottom: 25px;

            margin-bottom: 26px;

            border-bottom: 1px solid #eeeeee;

        }


        .as-form-header-icon {

            width: 49px;

            height: 49px;

            flex: 0 0 49px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 14px;

            background: var(--as-gradient);

            color: #fff;

            font-size: 19px;

            box-shadow:
                0 8px 22px rgba(221, 36, 118, .20);

        }


        .as-form-header h2 {

            margin: 0 0 5px;

            color: #222;

            font-size: 23px;

            line-height: 1.3;

            font-weight: 800;

        }


        .as-form-header p {

            margin: 0;

            color: #777;

            font-size: 13px;

            line-height: 1.5;

        }


        /* =========================================================
                               FORM
                            ========================================================= */

        .as-contact-form {

            display: flex;

            flex-direction: column;

            gap: 20px;

        }


        .as-form-group {

            margin: 0;

        }


        .as-form-group label {

            display: block;

            margin-bottom: 8px;

            color: #333;

            font-size: 13px;

            font-weight: 700;

        }


        .as-form-group label span {

            color: #dd2476;

        }


        .as-input-wrapper {

            position: relative;

        }


        .as-input-icon {

            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            width: 20px;

            color: #999;

            font-size: 15px;

            font-weight: 600;

            text-align: center;

            pointer-events: none;

            transition: color .2s ease;

        }


        .as-form-group input,
        .as-form-group textarea {

            width: 100%;

            border: 1px solid #dedede;

            border-radius: 13px;

            background: #fff;

            color: #222;

            font-family: inherit;

            font-size: 14px;

            outline: none;

            transition:
                border-color .2s ease,
                box-shadow .2s ease;

        }


        .as-form-group input {

            height: 52px;

            padding: 0 15px 0 47px;

        }


        .as-form-group textarea {

            min-height: 145px;

            padding: 15px 15px 15px 47px;

            resize: vertical;

            line-height: 1.65;

        }


        .as-form-group input::placeholder,
        .as-form-group textarea::placeholder {

            color: #aaa;

        }


        .as-form-group input:focus,
        .as-form-group textarea:focus {

            border-color: #dd2476;

            box-shadow:
                0 0 0 4px rgba(221, 36, 118, .08);

        }


        .as-input-wrapper:focus-within .as-input-icon {

            color: #dd2476;

        }


        .as-textarea-icon {

            top: 19px;

            transform: none;

        }


        /* =========================================================
                               VALIDATION
                            ========================================================= */

        .as-field-error {

            display: block;

            margin: 7px 0 0;

            color: #dc2626;

            font-size: 12px;

            line-height: 1.5;

        }


        /* =========================================================
                               SUBMIT BUTTON
                            ========================================================= */

        .as-submit-button {

            width: 100%;

            min-height: 55px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 12px;

            margin-top: 3px;

            border: none;

            border-radius: 15px;

            background: linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            color: #fff;

            font-family: inherit;

            font-size: 16px;

            font-weight: 750;

            letter-spacing: .2px;

            cursor: pointer;

            box-shadow:
                0 8px 23px rgba(221, 36, 118, .22);

            transition:
                transform .25s ease,
                box-shadow .25s ease,
                opacity .25s ease;

        }


        .as-submit-button:hover {

            transform: translateY(-2px);

            opacity: .94;

            box-shadow:
                0 13px 30px rgba(221, 36, 118, .27);

        }


        .as-submit-button:active {

            transform: translateY(0);

        }


        .as-submit-arrow {

            font-size: 20px;

            transition: transform .25s ease;

        }


        .as-submit-button:hover .as-submit-arrow {

            transform: translateX(4px);

        }


        .as-form-note {

            margin: -3px 0 0;

            color: #999;

            font-size: 11.5px;

            line-height: 1.55;

            text-align: center;

        }


        /* =========================================================
                               SPECIFIC HELP SECTION
                            ========================================================= */

        .as-specific-help {

            padding: 100px 0;

            background: #fafafa;

        }


        .as-specific-heading {

            max-width: 730px;

            margin: 0 auto 50px;

            text-align: center;

        }


        .as-specific-heading h2 {

            margin: 0 0 15px;

            color: #1d1d1d;

            font-size: 40px;

            line-height: 1.15;

            font-weight: 800;

            letter-spacing: -1.2px;

        }


        .as-specific-heading h2 span {

            background: var(--as-gradient);

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;

            background-clip: text;

        }


        .as-specific-heading p {

            margin: 0 auto;

            color: #6b6b6b;

            font-size: 15.5px;

            line-height: 1.75;

        }


        .as-specific-grid {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 20px;

        }


        .as-specific-card {

            padding: 28px 23px;

            background: #fff;

            border: 1px solid #eeeeee;

            border-radius: 19px;

            box-shadow:
                0 7px 25px rgba(0, 0, 0, .035);

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;

        }


        .as-specific-card:hover {

            transform: translateY(-5px);

            border-color: rgba(221, 36, 118, .18);

            box-shadow:
                0 16px 35px rgba(221, 36, 118, .08);

        }


        .as-specific-icon {

            width: 45px;

            height: 45px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 18px;

            border-radius: 13px;

            background: #fff2f5;

            color: #dd2476;

            font-size: 18px;

        }


        .as-specific-card h3 {

            margin: 0 0 9px;

            color: #252525;

            font-size: 16px;

            line-height: 1.4;

            font-weight: 750;

        }


        .as-specific-card p {

            margin: 0;

            color: #707070;

            font-size: 13.5px;

            line-height: 1.7;

        }


        /* =========================================================
                               FINAL CTA
                            ========================================================= */

        .as-contact-final {

            padding: 95px 0;

            background:
                linear-gradient(135deg,
                    #ff512f,
                    #dd2476);

        }


        .as-contact-final-inner {

            max-width: 780px;

            margin: 0 auto;

            text-align: center;

            color: #fff;

        }


        .as-final-label {

            margin-bottom: 14px;

            color: rgba(255, 255, 255, .78);

            font-size: 11px;

            font-weight: 800;

            letter-spacing: 2px;

        }


        .as-contact-final h2 {

            margin: 0 0 15px;

            color: #fff;

            font-size: clamp(35px, 5vw, 52px);

            line-height: 1.12;

            font-weight: 800;

            letter-spacing: -1.5px;

        }


        .as-contact-final p {

            max-width: 630px;

            margin: 0 auto;

            color: rgba(255, 255, 255, .90);

            font-size: 16px;

            line-height: 1.7;

        }


        /* =========================================================
                               TABLET
                            ========================================================= */

        @media (max-width: 1050px) {

            .as-contact-layout {

                grid-template-columns: 1fr;

                gap: 55px;

                max-width: 850px;

                margin: 0 auto;

            }


            .as-contact-info {

                padding-top: 0;

            }


            .as-contact-info>.as-section-label {

                display: block;

                text-align: center;

            }


            .as-contact-info h2 {

                text-align: center;

            }


            .as-contact-intro {

                margin-left: auto;

                margin-right: auto;

                text-align: center;

            }


            .as-help-list {

                max-width: 700px;

                margin: 0 auto;

            }


            .as-response-note {

                max-width: 700px;

                margin-left: auto;

                margin-right: auto;

            }


            .as-specific-grid {

                grid-template-columns: repeat(2, 1fr);

            }

        }


        /* =========================================================
                               MOBILE
                            ========================================================= */

        @media (max-width: 700px) {

            .as-contact-container {

                width: min(100% - 28px, 1180px);

            }


            .as-contact-hero {

                min-height: 430px;

                padding: 70px 18px;

            }


            .as-contact-hero h1 {

                font-size: 43px;

                letter-spacing: -1.7px;

            }


            .as-contact-hero-description {

                font-size: 15.5px;

            }


            .as-contact-main {

                padding: 70px 0;

            }


            .as-contact-info h2 {

                font-size: 33px;

            }


            .as-contact-intro {

                font-size: 14.5px;

            }


            .as-contact-form-card {

                padding: 25px 19px;

                border-radius: 20px;

            }


            .as-form-header {

                align-items: flex-start;

            }


            .as-form-header h2 {

                font-size: 20px;

            }


            .as-form-header p {

                font-size: 12px;

            }


            .as-specific-help {

                padding: 70px 0;

            }


            .as-specific-heading h2 {

                font-size: 32px;

            }


            .as-specific-heading p {

                font-size: 14.5px;

            }


            .as-specific-grid {

                grid-template-columns: 1fr;

            }


            .as-contact-final {

                padding: 70px 0;

            }


            .as-contact-final h2 {

                font-size: 36px;

            }


            .as-contact-final p {

                font-size: 14.5px;

            }

        }


        /* =========================================================
                               SMALL MOBILE
                            ========================================================= */

        @media (max-width: 450px) {

            .as-contact-alert {

                width: calc(100% - 28px);

                min-width: 0;

            }


            .as-contact-hero {

                min-height: 400px;

                padding: 60px 14px;

            }


            .as-contact-badge {

                font-size: 11px;

                padding: 8px 13px;

            }


            .as-contact-hero h1 {

                font-size: 35px;

                letter-spacing: -1.2px;

            }


            .as-contact-hero-description {

                font-size: 14px;

            }


            .as-contact-hero-subline {

                font-size: 11px;

            }


            .as-contact-hero-subline span {

                width: 25px;

            }


            .as-contact-info h2 {

                font-size: 29px;

            }


            .as-help-card {

                gap: 11px;

            }


            .as-help-icon {

                width: 40px;

                height: 40px;

                flex-basis: 40px;

            }


            .as-help-card h3 {

                font-size: 14px;

            }


            .as-help-card p {

                font-size: 12.5px;

            }


            .as-contact-form-card {

                padding: 20px 15px;

            }


            .as-form-header {

                gap: 11px;

            }


            .as-form-header-icon {

                width: 42px;

                height: 42px;

                flex-basis: 42px;

            }


            .as-form-header h2 {

                font-size: 18px;

            }


            .as-form-group input {

                height: 49px;

            }


            .as-submit-button {

                min-height: 52px;

                font-size: 15px;

            }


            .as-contact-final h2 {

                font-size: 31px;

            }

        }
    </style>

    <style>
        .custom-alert-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.38);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999999;
            padding: 20px;
        }

        .custom-alert-box {
            width: 100%;
            max-width: 490px;
            background: #fff;
            border-radius: 16px;
            padding: 34px 36px 26px;
            text-align: center;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.22);
            animation: alertPopup 0.25s ease;
        }

        @keyframes alertPopup {
            from {
                opacity: 0;
                transform: scale(0.92);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .custom-alert-icon {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            margin: 0 auto 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
        }

        .custom-alert-icon.success {
            color: #20c98b;
            background: #e8faf3;
            box-shadow: 0 0 0 12px #f2fcf8;
        }

        .custom-alert-icon.error {
            color: #ef4444;
            background: #fff0f0;
            box-shadow: 0 0 0 12px #fff7f7;
        }

        .custom-alert-title {
            font-size: 27px;
            font-weight: 700;
            color: #172033;
            margin-bottom: 10px;
        }

        .custom-alert-message {
            font-size: 17px;
            line-height: 1.55;
            color: #6b7280;
            margin-bottom: 24px;
        }

        .custom-alert-button {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 14px 20px;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .custom-alert-button.success {
            background: linear-gradient(90deg, #ff4b2b, #e91e63);
        }

        .custom-alert-button.error {
            background: linear-gradient(90deg, #ef4444, #dc2626);
        }

        .custom-alert-button:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            .custom-alert-box {
                padding: 30px 22px 22px;
            }

            .custom-alert-title {
                font-size: 23px;
            }

            .custom-alert-message {
                font-size: 15px;
            }
        }
    </style>
@endsection


@section('content')
    <div class="as-contact-page">

        <section class="as-contact-hero">

            <img src="{{ asset('images/coursel.png') }}" class="as-contact-hero-image"
                alt="LGBTQ community celebrating pride with rainbow flags and joy">

            <div class="as-contact-container">

                <div class="as-contact-hero-content">

                    <div class="as-contact-badge">

                        <span class="as-badge-dot"></span>

                        AffirmSpace Support

                    </div>


                    <h1>
                        Contact
                        <span>AffirmSpace</span>
                    </h1>


                    <p class="as-contact-hero-description">

                        Have a question, feedback, or need support?
                        We're here to help.

                    </p>


                    <div class="as-contact-hero-subline">

                        <span></span>

                        <strong>
                            We're listening.
                        </strong>

                        <span></span>

                    </div>

                </div>

            </div>

        </section>

        <section class="as-contact-main">

            <div class="as-contact-container">

                <div class="as-contact-layout">

                    <div class="as-contact-info">

                        <span class="as-section-label">
                            GET IN TOUCH
                        </span>


                        <h2>
                            How can we
                            <span>help?</span>
                        </h2>


                        <p class="as-contact-intro">

                            Whether it's something about your account, a question
                            about dating, chat, community, or counselling, or just
                            feedback on how we can do better — send us a message
                            and we'll get back to you as soon as we can.

                        </p>


                        <div class="as-help-list">


                            {{-- Account --}}
                            <div class="as-help-card">

                                <div class="as-help-icon">
                                    👤
                                </div>

                                <div>

                                    <h3>
                                        Account or login issues
                                    </h3>

                                    <p>
                                        Let us know what's happening and we'll
                                        sort it out.
                                    </p>

                                </div>

                            </div>


                            {{-- Counselling --}}
                            <div class="as-help-card">

                                <div class="as-help-icon">
                                    ♥
                                </div>

                                <div>

                                    <h3>
                                        Questions about counselling or providers
                                    </h3>

                                    <p>
                                        Reach out and we'll point you in the
                                        right direction.
                                    </p>

                                </div>

                            </div>


                            {{-- Safety --}}
                            <div class="as-help-card">

                                <div class="as-help-icon">
                                    !
                                </div>

                                <div>

                                    <h3>
                                        Report a concern
                                    </h3>

                                    <p>
                                        If something happened on the platform that
                                        didn't feel safe or respectful, tell us.
                                        We take this seriously.
                                    </p>

                                </div>

                            </div>


                            {{-- Partnership --}}
                            <div class="as-help-card">

                                <div class="as-help-icon">
                                    ↗
                                </div>

                                <div>

                                    <h3>
                                        Partnership or press inquiries
                                    </h3>

                                    <p>
                                        Happy to hear from you. Just include a
                                        bit of context in your message.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Response --}}
                        <div class="as-response-note">

                            <div class="as-response-icon">
                                ✓
                            </div>

                            <div>

                                <strong>
                                    We're here to help.
                                </strong>

                                <p>
                                    We aim to respond to every message as quickly
                                    as we can.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="as-contact-form-card">


                        <div class="as-form-header">

                            <div class="as-form-header-icon">
                                ✉
                            </div>

                            <div>

                                <h2>
                                    Send us a message
                                </h2>

                                <p>
                                    Tell us what's on your mind and our team
                                    will get back to you.
                                </p>

                            </div>

                        </div>

                        @if (session('success') || session('error'))
                            @php
                                $isSuccess = session('success');
                                $message = session('success') ?? session('error');
                            @endphp

                            <div class="custom-alert-overlay" id="customAlert">

                                <div class="custom-alert-box">

                                    <div class="custom-alert-icon {{ $isSuccess ? 'success' : 'error' }}">
                                        @if ($isSuccess)
                                            <i class="fa-solid fa-check"></i>
                                        @else
                                            <i class="fa-solid fa-xmark"></i>
                                        @endif
                                    </div>

                                    <div class="custom-alert-title">
                                        {{ $isSuccess ? 'Thank You for Contacting Us!' : 'Something Went Wrong!' }}
                                    </div>

                                    <div class="custom-alert-message">
                                        {{ $message }}
                                    </div>

                                    <button type="button"
                                        class="custom-alert-button {{ $isSuccess ? 'success' : 'error' }}"
                                        onclick="closeCustomAlert()">
                                        Done
                                    </button>

                                </div>
                            </div>
                        @endif


                        <form method="POST" action="{{ route('AdminSend') }}" class="as-contact-form">

                            @csrf


                            {{-- Full Name --}}
                            <div class="as-form-group">

                                <label for="contact-name">
                                    Full Name
                                    <span>*</span>
                                </label>

                                <div class="as-input-wrapper">

                                    <span class="as-input-icon">
                                        👤
                                    </span>

                                    <input id="contact-name" type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Enter your full name">

                                </div>

                                @error('name')
                                    <small class="as-field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- Email --}}
                            <div class="as-form-group">

                                <label for="contact-email">
                                    Email Address
                                    <span>*</span>
                                </label>

                                <div class="as-input-wrapper">

                                    <span class="as-input-icon">
                                        @
                                    </span>

                                    <input id="contact-email" type="email" name="email" value="{{ old('email') }}"
                                        placeholder="Enter your email address">

                                </div>

                                @error('email')
                                    <small class="as-field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- Subject --}}
                            <div class="as-form-group">

                                <label for="contact-subject">
                                    Subject
                                    <span>*</span>
                                </label>

                                <div class="as-input-wrapper">

                                    <span class="as-input-icon">
                                        #
                                    </span>

                                    <input id="contact-subject" type="text" name="subject" value="{{ old('subject') }}"
                                        placeholder="What can we help you with?">

                                </div>

                                @error('subject')
                                    <small class="as-field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- Message --}}
                            <div class="as-form-group">

                                <label for="contact-message">
                                    Message
                                    <span>*</span>
                                </label>

                                <div class="as-input-wrapper">

                                    <span class="as-input-icon as-textarea-icon">
                                        ✎
                                    </span>

                                    <textarea id="contact-message" name="message" rows="5" placeholder="Tell us how we can help...">{{ old('message') }}</textarea>

                                </div>

                                @error('message')
                                    <small class="as-field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- Submit --}}
                            <button type="submit" class="as-submit-button">

                                <span>
                                    Send Message
                                </span>

                                <span class="as-submit-arrow">
                                    →
                                </span>

                            </button>


                            <p class="as-form-note">
                                We aim to respond to every message as quickly
                                as we can.
                            </p>

                        </form>

                    </div>

                </div>

            </div>

        </section>

        <section class="as-specific-help">

            <div class="as-contact-container">


                <div class="as-specific-heading">

                    <span class="as-section-label">
                        LOOKING FOR SOMETHING SPECIFIC?
                    </span>


                    <h2>
                        Tell us what you
                        <span>need.</span>
                    </h2>


                    <p>
                        Whatever brings you to AffirmSpace, we're here to help
                        you find the right direction.
                    </p>

                </div>


                <div class="as-specific-grid">


                    {{-- Account --}}
                    <div class="as-specific-card">

                        <div class="as-specific-icon">
                            👤
                        </div>

                        <h3>
                            Account or Login
                        </h3>

                        <p>
                            Let us know what's happening with your account or
                            login and we'll help you work through it.
                        </p>

                    </div>


                    {{-- Counselling --}}
                    <div class="as-specific-card">

                        <div class="as-specific-icon">
                            ♥
                        </div>

                        <h3>
                            Counselling & Providers
                        </h3>

                        <p>
                            Have questions about counselling or providers?
                            Reach out and we'll point you in the right direction.
                        </p>

                    </div>


                    {{-- Safety --}}
                    <div class="as-specific-card">

                        <div class="as-specific-icon">
                            🛡
                        </div>

                        <h3>
                            Report a Concern
                        </h3>

                        <p>
                            If something happened on the platform that didn't
                            feel safe or respectful, tell us.
                        </p>

                    </div>


                    {{-- Partnership --}}
                    <div class="as-specific-card">

                        <div class="as-specific-icon">
                            ↗
                        </div>

                        <h3>
                            Partnership or Press
                        </h3>

                        <p>
                            For partnerships or press inquiries, include a little
                            context in your message so we know how to help.
                        </p>

                    </div>

                </div>

            </div>

        </section>

        <section class="as-contact-final">

            <div class="as-contact-container">

                <div class="as-contact-final-inner">

                    <div class="as-final-label">
                        AFFIRMSPACE SUPPORT
                    </div>


                    <h2>
                        Your voice helps us
                        <br>
                        <span>build better.</span>
                    </h2>


                    <p>
                        Have feedback, a question, or something you'd like us
                        to know? Get in touch with the AffirmSpace team.
                    </p>

                </div>

            </div>

        </section>
    </div>
@endsection

@section('script')
    <script>
        function closeCustomAlert(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            document.querySelectorAll('.custom-alert-overlay').forEach(function(popup) {
                popup.remove();
            });
        }
    </script>
@endsection
