@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="AffirmSpace is a global LGBTQ+ platform for dating, chat, community, and gender-affirming care, built around connection, safety, and genuine understanding.">

    <title>About AffirmSpace – LGBTQ+ Dating, Chat, Community & Care Platform</title>

    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ community platform, LGBTQ+ dating app, LGBTQ+ chat platform, LGBTQ+ counselling platform, LGBTQ+ community, LGBTQ+ mental health, gender-affirming care, safe LGBTQ+ platform">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        .as-about-page {
            width: 100%;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            color: #222;
            background: #fff;
        }

        .as-about-page *,
        .as-about-page *::before,
        .as-about-page *::after {
            box-sizing: border-box;
        }

        .as-about-page img {
            max-width: 100%;
        }

        .as-about-container {
            width: min(1180px, 92%);
            margin: 0 auto;
        }


        /* =========================================================
                           HERO
                        ========================================================= */

        .as-about-hero {
            position: relative;
            min-height: 570px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 110px 6%;
            text-align: center;
            color: #fff;
            overflow: hidden;
            isolation: isolate;
        }

        .as-about-hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -3;
        }

        .as-about-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg,
                    rgba(0, 0, 0, 0.76),
                    rgba(0, 0, 0, 0.48),
                    rgba(0, 0, 0, 0.68));
            z-index: -2;
        }

        .as-about-hero::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 5px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            z-index: -1;
        }

        .as-about-hero-content {
            width: min(900px, 100%);
            margin: 0 auto;
        }

        .as-about-eyebrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 17px;
            margin-bottom: 22px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .as-about-hero h1 {
            margin: 0 0 22px;
            color: #fff;
            font-size: clamp(2.4rem, 5vw, 4.5rem);
            line-height: 1.08;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .as-about-hero h1 span {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .as-about-hero p {
            max-width: 800px;
            margin: 0 auto;
            color: rgba(255, 255, 255, 0.92);
            font-size: clamp(1rem, 2vw, 1.18rem);
            line-height: 1.8;
        }


        /* =========================================================
                           GENERAL SECTION
                        ========================================================= */

        .as-about-section {
            padding: 95px 0;
        }

        .as-about-section-light {
            background: #fafafa;
        }

        .as-about-section-white {
            background: #fff;
        }

        .as-about-section-header {
            max-width: 780px;
            margin: 0 auto 55px;
            text-align: center;
        }

        .as-about-section-label {
            display: inline-block;
            margin-bottom: 13px;
            color: #dd2476;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .as-about-section-header h2 {
            margin: 0 0 18px;
            color: #171717;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.035em;
        }

        .as-about-section-header p {
            margin: 0;
            color: #666;
            font-size: 16px;
            line-height: 1.8;
        }


        /* =========================================================
                           WHO WE ARE
                        ========================================================= */

        .as-about-who {
            padding: 95px 0 80px;
        }

        .as-about-who-grid {
            display: grid;
            grid-template-columns: minmax(0, 0.85fr) minmax(0, 1.15fr);
            gap: 70px;
            align-items: center;
        }

        .as-about-who-title h2 {
            margin: 0;
            color: #171717;
            font-size: clamp(2rem, 4vw, 3.1rem);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.035em;
        }

        .as-about-who-title h2 span {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .as-about-who-copy {
            position: relative;
            padding: 35px 38px;
            border-radius: 24px;
            background: #fff;
            border: 1px solid #eeeeee;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.06);
        }

        .as-about-who-copy::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(180deg, #ff512f, #dd2476);
        }

        .as-about-who-copy p {
            margin: 0;
            color: #555;
            font-size: 17px;
            line-height: 1.85;
        }


        /* =========================================================
                           WHY WE BUILT
                        ========================================================= */

        .as-about-why {
            padding: 100px 0;
            background: #fafafa;
        }

        .as-about-why-box {
            max-width: 1000px;
            margin: 0 auto;
            padding: 50px;
            border-radius: 28px;
            background: #fff;
            border: 1px solid #eeeeee;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.06);
        }

        .as-about-why-box h2 {
            margin: 0 0 25px;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.035em;
            color: #171717;
        }

        .as-about-why-box h2 span {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .as-about-why-box p {
            margin: 0;
            color: #555;
            font-size: 16px;
            line-height: 1.9;
        }


        /* =========================================================
                           FEATURE CARDS
                        ========================================================= */

        .as-about-features {
            padding: 100px 0;
            background: #fff;
        }

        .as-about-feature-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 25px;
        }

        .as-about-feature-card {
            position: relative;
            padding: 35px 32px;
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 22px;
            overflow: hidden;
            transition: transform 0.3s ease,
                box-shadow 0.3s ease,
                border-color 0.3s ease;
        }

        .as-about-feature-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .as-about-feature-card:hover {
            transform: translateY(-7px);
            border-color: rgba(221, 36, 118, 0.16);
            box-shadow:
                0 18px 45px rgba(255, 81, 47, 0.10),
                0 10px 35px rgba(221, 36, 118, 0.09);
        }

        .as-about-feature-card:hover::before {
            transform: scaleX(1);
        }

        .as-about-feature-icon {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            border-radius: 15px;
            background: #fff2f5;
            font-size: 25px;
        }

        .as-about-feature-card h3 {
            margin: 0 0 14px;
            color: #202020;
            font-size: 20px;
            line-height: 1.35;
            font-weight: 750;
        }

        .as-about-feature-card p {
            margin: 0;
            color: #626262;
            font-size: 15px;
            line-height: 1.8;
        }

        .as-about-feature-card a {
            color: #dd2476;
            font-weight: 700;
            text-decoration: none;
        }

        .as-about-feature-card a:hover {
            color: #ff512f;
        }


        /* =========================================================
                           COUNSELLING DISCLAIMER
                        ========================================================= */

        .as-about-disclaimer {
            max-width: 920px;
            margin: 30px auto 0;
            padding: 22px 25px;
            border-radius: 16px;
            background: #fff8fa;
            border: 1px solid #f6dce5;
            color: #666;
            font-size: 13px;
            line-height: 1.7;
        }


        /* =========================================================
                           EXPLORE AFFIRMSPACE
                        ========================================================= */

        .as-about-explore {
            padding: 100px 0;
            background: #fafafa;
        }

        .as-about-explore-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 18px;
        }

        .as-about-explore-card {
            display: flex;
            flex-direction: column;
            min-height: 235px;
            padding: 28px 23px;
            border-radius: 20px;
            background: #fff;
            border: 1px solid #eeeeee;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .as-about-explore-card:hover {
            transform: translateY(-7px);
            border-color: rgba(221, 36, 118, 0.2);
            box-shadow: 0 18px 45px rgba(221, 36, 118, 0.10);
        }

        .as-about-explore-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            border-radius: 14px;
            background: linear-gradient(135deg, #fff1f4, #fff7f3);
            font-size: 22px;
        }

        .as-about-explore-card h3 {
            margin: 0 0 10px;
            color: #202020;
            font-size: 17px;
            line-height: 1.3;
            font-weight: 750;
        }

        .as-about-explore-card p {
            margin: 0;
            color: #666;
            font-size: 13px;
            line-height: 1.65;
        }

        .as-about-explore-link {
            margin-top: auto;
            padding-top: 20px;
            color: #dd2476;
            font-size: 13px;
            font-weight: 750;
        }


        /* =========================================================
                           VISION
                        ========================================================= */

        .as-about-vision {
            position: relative;
            padding: 110px 0;
            background: #111;
            color: #fff;
            overflow: hidden;
        }

        .as-about-vision::before {
            content: "";
            position: absolute;
            width: 430px;
            height: 430px;
            top: -220px;
            left: -150px;
            border-radius: 50%;
            background: rgba(255, 81, 47, 0.13);
            filter: blur(10px);
        }

        .as-about-vision::after {
            content: "";
            position: absolute;
            width: 450px;
            height: 450px;
            right: -180px;
            bottom: -250px;
            border-radius: 50%;
            background: rgba(221, 36, 118, 0.14);
            filter: blur(10px);
        }

        .as-about-vision-content {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .as-about-vision-label {
            display: inline-block;
            margin-bottom: 18px;
            color: #ff8a72;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .as-about-vision h2 {
            margin: 0 0 25px;
            color: #fff;
            font-size: clamp(2.2rem, 4vw, 3.5rem);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.035em;
        }

        .as-about-vision p {
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 17px;
            line-height: 1.9;
        }


        /* =========================================================
                           FAQ
                        ========================================================= */

        .as-about-faq {
            padding: 100px 0;
            background: #fff;
        }

        .as-about-faq-container {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .as-about-faq-item {
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.035);
            transition: all 0.3s ease;
        }

        .as-about-faq-item:hover {
            border-color: rgba(221, 36, 118, 0.18);
            box-shadow: 0 10px 30px rgba(221, 36, 118, 0.07);
        }

        .as-about-faq-question {
            width: 100%;
            min-height: 72px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border: 0;
            background: #fff;
            color: #222;
            font-family: inherit;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.5;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .as-about-faq-question:hover {
            color: #dd2476;
        }

        .as-about-faq-question::after {
            content: "+";
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff1f5;
            color: #dd2476;
            font-size: 23px;
            font-weight: 400;
            line-height: 1;
            transition: all 0.3s ease;
        }

        .as-about-faq-question.active::after {
            content: "−";
            color: #fff;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            transform: rotate(180deg);
        }

        .as-about-faq-answer {
            max-height: 0;
            overflow: hidden;
            background: #fff;
            transition: max-height 0.35s ease;
        }

        .as-about-faq-answer p {
            margin: 0;
            padding: 0 70px 24px 24px;
            color: #666;
            font-size: 15px;
            line-height: 1.75;
        }

        .as-about-faq-item:has(.as-about-faq-question.active) {
            border-color: rgba(221, 36, 118, 0.22);
            box-shadow: 0 12px 35px rgba(221, 36, 118, 0.08);
        }

        .as-about-faq-item:has(.as-about-faq-question.active) .as-about-faq-question {
            color: #dd2476;
        }


        /* =========================================================
                           FINAL CTA
                        ========================================================= */

        .as-about-cta {
            position: relative;
            padding: 100px 0;
            overflow: hidden;
            background: linear-gradient(135deg,
                    #fff5f2 0%,
                    #fff 45%,
                    #fff3f7 100%);
            text-align: center;
        }

        .as-about-cta::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            top: -180px;
            left: -100px;
            border-radius: 50%;
            background: rgba(255, 81, 47, 0.10);
            filter: blur(20px);
        }

        .as-about-cta::after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            right: -120px;
            bottom: -190px;
            border-radius: 50%;
            background: rgba(221, 36, 118, 0.10);
            filter: blur(20px);
        }

        .as-about-cta-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .as-about-cta h2 {
            margin: 0 0 18px;
            color: #171717;
            font-size: clamp(2.1rem, 4vw, 3.4rem);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .as-about-cta p {
            max-width: 680px;
            margin: 0 auto 32px;
            color: #626262;
            font-size: 16px;
            line-height: 1.8;
        }

        .as-about-cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            padding: 0 30px;
            border-radius: 999px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff !important;
            font-size: 15px;
            font-weight: 750;
            text-decoration: none !important;
            box-shadow: 0 12px 30px rgba(221, 36, 118, 0.22);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .as-about-cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 17px 38px rgba(221, 36, 118, 0.30);
        }


        /* =========================================================
                           TABLET
                        ========================================================= */

        @media (max-width: 1100px) {

            .as-about-explore-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .as-about-who-grid {
                gap: 45px;
            }
        }


        @media (max-width: 900px) {

            .as-about-section,
            .as-about-features,
            .as-about-explore,
            .as-about-faq {
                padding: 80px 0;
            }

            .as-about-who {
                padding: 80px 0;
            }

            .as-about-who-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .as-about-who-title {
                text-align: center;
            }

            .as-about-feature-grid {
                grid-template-columns: 1fr;
            }

            .as-about-explore-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .as-about-why-box {
                padding: 40px;
            }
        }


        /* =========================================================
                           MOBILE
                        ========================================================= */

        @media (max-width: 600px) {

            .as-about-container {
                width: min(92%, 500px);
            }

            .as-about-hero {
                min-height: 500px;
                padding: 90px 20px;
            }

            .as-about-eyebrow {
                padding: 7px 13px;
                font-size: 11px;
            }

            .as-about-hero h1 {
                font-size: 2.45rem;
                line-height: 1.1;
                letter-spacing: -0.035em;
            }

            .as-about-hero p {
                font-size: 14px;
                line-height: 1.75;
            }

            .as-about-section,
            .as-about-features,
            .as-about-explore,
            .as-about-faq {
                padding: 65px 0;
            }

            .as-about-who {
                padding: 65px 0;
            }

            .as-about-section-header {
                margin-bottom: 38px;
            }

            .as-about-section-header h2,
            .as-about-who-title h2,
            .as-about-why-box h2 {
                font-size: 2rem;
            }

            .as-about-section-header p {
                font-size: 14px;
                line-height: 1.7;
            }

            .as-about-who-title h2 {
                font-size: 2.2rem;
            }

            .as-about-who-copy {
                padding: 28px 25px 28px 30px;
                border-radius: 20px;
            }

            .as-about-who-copy p {
                font-size: 15px;
                line-height: 1.75;
            }

            .as-about-why {
                padding: 65px 0;
            }

            .as-about-why-box {
                padding: 30px 24px;
                border-radius: 22px;
            }

            .as-about-why-box p {
                font-size: 14px;
                line-height: 1.8;
            }

            .as-about-feature-card {
                padding: 28px 24px;
                border-radius: 20px;
            }

            .as-about-feature-card h3 {
                font-size: 18px;
            }

            .as-about-feature-card p {
                font-size: 14px;
                line-height: 1.75;
            }

            .as-about-disclaimer {
                padding: 18px;
                font-size: 12px;
            }

            .as-about-explore-grid {
                grid-template-columns: 1fr;
            }

            .as-about-explore-card {
                min-height: auto;
                padding: 25px;
            }

            .as-about-explore-link {
                padding-top: 18px;
            }

            .as-about-vision {
                padding: 75px 0;
            }

            .as-about-vision h2 {
                font-size: 2.15rem;
            }

            .as-about-vision p {
                font-size: 14px;
                line-height: 1.8;
            }

            .as-about-faq-container {
                gap: 11px;
            }

            .as-about-faq-item {
                border-radius: 14px;
            }

            .as-about-faq-question {
                min-height: 65px;
                padding: 17px 18px;
                font-size: 14px;
                gap: 12px;
            }

            .as-about-faq-question::after {
                width: 32px;
                height: 32px;
                font-size: 21px;
            }

            .as-about-faq-answer p {
                padding: 0 18px 20px;
                font-size: 13px;
                line-height: 1.7;
            }

            .as-about-cta {
                padding: 75px 20px;
            }

            .as-about-cta h2 {
                font-size: 2.15rem;
            }

            .as-about-cta p {
                font-size: 14px;
                line-height: 1.75;
            }

            .as-about-cta-button {
                width: 100%;
                max-width: 300px;
            }
        }


        @media (max-width: 360px) {

            .as-about-hero h1 {
                font-size: 2.1rem;
            }

            .as-about-feature-card,
            .as-about-who-copy,
            .as-about-why-box {
                padding-left: 20px;
                padding-right: 20px;
            }

            .as-about-cta h2 {
                font-size: 1.9rem;
            }
        }
    </style>
@endsection


@section('content')
    <div class="as-about-page">

        <section class="as-about-hero">

            <img src="{{ asset('images/coursel.png') }}" class="as-about-hero-image"
                alt="LGBTQ community celebrating pride with rainbow flags and joy">

            <div class="as-about-hero-content">

                <div class="as-about-eyebrow">
                    About AffirmSpace
                </div>

                <h1>
                    More Than a <span>Dating Platform</span>
                </h1>

                <p>
                    AffirmSpace is a global LGBTQ+ community, chat platform, and
                    counselling ecosystem built for connection, safety, and genuine
                    understanding — not just another dating app.
                </p>

            </div>

        </section>

        <section class="as-about-who">

            <div class="as-about-container">

                <div class="as-about-who-grid">

                    <div class="as-about-who-title">

                        <span class="as-about-section-label">
                            Who We Are
                        </span>

                        <h2>
                            Built around
                            <span>understanding.</span>
                        </h2>

                    </div>

                    <div class="as-about-who-copy">

                        <p>
                            AffirmSpace is built by a team with backgrounds in
                            software engineering, mental health advocacy, and
                            LGBTQ+ community organizing, building for a global
                            LGBTQ+ audience.
                        </p>

                    </div>

                </div>

            </div>

        </section>

        <section class="as-about-why">

            <div class="as-about-container">

                <div class="as-about-why-box">

                    <span class="as-about-section-label">
                        Why We Built AffirmSpace
                    </span>

                    <h2>
                        One space instead of
                        <span>four separate searches.</span>
                    </h2>

                    <p>
                        We kept running into the same problem: every dating app
                        treats you as a profile, every chat app treats you as a
                        stranger, and healthcare discovery leaves LGBTQ+ people
                        searching for providers who actually understand what
                        they're dealing with. Nowhere brought dating, conversation,
                        community, and LGBTQ+-friendly care together in one place.
                        So we built AffirmSpace for gay, lesbian, bisexual,
                        transgender, non-binary, pansexual, and asexual people —
                        and anyone still figuring things out — as a single space
                        instead of four separate searches.
                    </p>

                </div>

            </div>

        </section>

        <section class="as-about-features">

            <div class="as-about-container">

                <div class="as-about-section-header">

                    <span class="as-about-section-label">
                        What AffirmSpace Stands For
                    </span>

                    <h2>
                        Built for the full
                        LGBTQ+ experience
                    </h2>

                    <p>
                        Dating is one part of AffirmSpace. The platform is designed
                        around connection, conversation, community, and support.
                    </p>

                </div>


                <div class="as-about-feature-grid">


                    {{-- Beyond Dating --}}

                    <div class="as-about-feature-card">

                        <div class="as-about-feature-icon">
                            ❤️
                        </div>

                        <h3>
                            Beyond Traditional LGBTQ+ Dating Apps
                        </h3>

                        <p>
                            Unlike LGBTQ+ dating apps built around swiping and
                            quick matches, AffirmSpace is built around deeper
                            connection — trust, shared experience, and mutual
                            understanding, not just attraction. Dating is one part
                            of AffirmSpace, not the whole point of it.
                        </p>

                    </div>


                    {{-- Safe Community --}}

                    <div class="as-about-feature-card">

                        <div class="as-about-feature-icon">
                            🛡️
                        </div>

                        <h3>
                            A Safe LGBTQ+ Community
                        </h3>

                        <p>
                            AffirmSpace was created to provide a secure, inclusive
                            environment where people can express their identity
                            freely and connect without fear of judgment. As a safe
                            LGBTQ+ community platform, we prioritize respectful
                            interaction, privacy, and meaningful conversation for
                            people across the full LGBTQ+ spectrum.
                        </p>

                    </div>


                    {{-- Chat --}}

                    <div class="as-about-feature-card">

                        <div class="as-about-feature-icon">
                            💬
                        </div>

                        <h3>
                            Meaningful LGBTQ+ Chat & Real Connections
                        </h3>

                        <p>
                            Whether you're looking for casual conversation,
                            friendship, or a long-term relationship, AffirmSpace
                            connects people through inclusive
                            <a href="{{ route('chat') }}">LGBTQ+ chat</a>
                            and community discussion, with the option to stay
                            anonymous for as long as you need to.
                        </p>

                    </div>


                    {{-- Counselling --}}

                    <div class="as-about-feature-card">

                        <div class="as-about-feature-icon">
                            🧠
                        </div>

                        <h3>
                            Built-In Counselling Support
                        </h3>

                        <p>
                            AffirmSpace goes beyond social networking by connecting
                            members directly with LGBTQ+-friendly counselling
                            support — guidance for mental health, identity,
                            relationships, and personal growth. Sessions are
                            offered by trained counsellors, and in some cases by
                            supervised interns working under the oversight of a
                            licensed professional. Any session led by a supervised
                            intern is clearly labeled as such before you book, so
                            you always know who you're speaking with and what
                            oversight is in place.
                        </p>

                    </div>


                    {{-- Identity --}}

                    <div class="as-about-feature-card">

                        <div class="as-about-feature-icon">
                            🌈
                        </div>

                        <h3>
                            Identity & Pronoun Respect
                        </h3>

                        <p>
                            We believe identity deserves recognition, not
                            explanation. AffirmSpace lets members express
                            themselves through customizable profiles, pronoun
                            options, and inclusive identity fields built for the
                            LGBTQ+ community from the start — not added on
                            afterward.
                        </p>

                    </div>


                    {{-- Care --}}

                    <div class="as-about-feature-card">

                        <div class="as-about-feature-icon">
                            🤝
                        </div>

                        <h3>
                            LGBTQ+-Friendly Care Discovery
                        </h3>

                        <p>
                            AffirmSpace helps you find and connect with
                            LGBTQ+-friendly counsellors and gender-affirming care
                            providers. AffirmSpace does not provide medical advice
                            or treatment directly. The care itself happens between
                            you and the provider you choose.
                        </p>

                    </div>

                </div>


                <div class="as-about-disclaimer">

                    <strong>About counselling support:</strong>
                    Sessions are offered by trained counsellors, and in some cases
                    by supervised interns working under the oversight of a licensed
                    professional. Any session led by a supervised intern is clearly
                    labeled before booking so you know who you're speaking with
                    and what oversight is in place.

                </div>

            </div>

        </section>

        <section class="as-about-explore">

            <div class="as-about-container">

                <div class="as-about-section-header">

                    <span class="as-about-section-label">
                        Explore AffirmSpace
                    </span>

                    <h2>
                        More than one way to connect
                    </h2>

                    <p>
                        Explore the different parts of AffirmSpace and find the
                        experience that fits what you're looking for.
                    </p>

                </div>


                <div class="as-about-explore-grid">


                    {{-- Dating --}}

                    <a href="{{ route('chatAndDating') }}" class="as-about-explore-card">

                        <div class="as-about-explore-icon">
                            ❤️
                        </div>

                        <h3>
                            Dating
                        </h3>

                        <p>
                            Real connection, not endless swiping.
                        </p>

                        <span class="as-about-explore-link">
                            Explore LGBTQ+ Dating →
                        </span>

                    </a>


                    {{-- Chat --}}

                    <a href="{{ route('chat') }}" class="as-about-explore-card">

                        <div class="as-about-explore-icon">
                            💬
                        </div>

                        <h3>
                            Chat
                        </h3>

                        <p>
                            Private and group conversations, anonymous if you want.
                        </p>

                        <span class="as-about-explore-link">
                            Explore LGBTQ+ Chat →
                        </span>

                    </a>


                    {{-- Counselling --}}

                    <a href="{{ route('counselling') }}" class="as-about-explore-card">

                        <div class="as-about-explore-icon">
                            🧠
                        </div>

                        <h3>
                            Counselling & Care
                        </h3>

                        <p>
                            LGBTQ+-friendly counsellors and gender-affirming care
                            discovery.
                        </p>

                        <span class="as-about-explore-link">
                            Explore Counselling →
                        </span>

                    </a>


                    {{-- Events --}}

                    <a href="{{ route('events') }}" class="as-about-explore-card">

                        <div class="as-about-explore-icon">
                            📅
                        </div>

                        <h3>
                            Events
                        </h3>

                        <p>
                            Meetups, workshops, and gatherings, hosted by the
                            community.
                        </p>

                        <span class="as-about-explore-link">
                            Explore Events →
                        </span>

                    </a>


                    {{-- Community --}}

                    <a href="{{ route('community') }}" class="as-about-explore-card">

                        <div class="as-about-explore-icon">
                            🌈
                        </div>

                        <h3>
                            Community
                        </h3>

                        <p>
                            Groups and discussions built around identity and shared
                            experience.
                        </p>

                        <span class="as-about-explore-link">
                            Explore Community →
                        </span>

                    </a>

                </div>

            </div>

        </section>

        <section class="as-about-vision">

            <div class="as-about-container">

                <div class="as-about-vision-content">

                    <span class="as-about-vision-label">
                        Our Vision
                    </span>

                    <h2>
                        A place where connection,
                        community & wellbeing
                        belong together.
                    </h2>

                    <p>
                        Our vision is a trusted global platform where LGBTQ+ people
                        can connect, share experience, and find real understanding
                        and support — where community, relationships, and mental
                        wellbeing are supported together, in one safe digital space,
                        for LGBTQ+ people wherever they are.
                    </p>

                </div>

            </div>

        </section>

        <section class="as-about-faq">

            <div class="as-about-container">

                <div class="as-about-section-header">

                    <span class="as-about-section-label">
                        Frequently Asked Questions
                    </span>

                    <h2>
                        About AffirmSpace
                    </h2>

                </div>


                <div class="as-about-faq-container">


                    {{-- FAQ 1 --}}

                    <div class="as-about-faq-item">

                        <button type="button" class="as-about-faq-question">

                            Who's behind AffirmSpace?

                        </button>

                        <div class="as-about-faq-answer">

                            <p>
                                A team with backgrounds in software engineering,
                                mental health advocacy, and LGBTQ+ community
                                organizing.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 2 --}}

                    <div class="as-about-faq-item">

                        <button type="button" class="as-about-faq-question">

                            Is AffirmSpace available worldwide?

                        </button>

                        <div class="as-about-faq-answer">

                            <p>
                                Yes. AffirmSpace is designed for LGBTQ+ people
                                worldwide, not limited to any one country.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 3 --}}

                    <div class="as-about-faq-item">

                        <button type="button" class="as-about-faq-question">

                            Is my identity safe on AffirmSpace?

                        </button>

                        <div class="as-about-faq-answer">

                            <p>
                                Yes. You control how much you reveal, from a fully
                                public profile to full anonymity in chat. That
                                choice is yours, and it can change anytime.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 4 --}}

                    <div class="as-about-faq-item">

                        <button type="button" class="as-about-faq-question">

                            Does AffirmSpace provide therapy directly?

                        </button>

                        <div class="as-about-faq-answer">

                            <p>
                                No. We help you find and connect with
                                LGBTQ+-friendly counsellors and gender-affirming
                                care providers — the care itself happens directly
                                between you and them.
                            </p>

                        </div>

                    </div>


                </div>

            </div>

        </section>

        <section class="as-about-cta">

            <div class="as-about-container">

                <div class="as-about-cta-content">

                    <h2>
                        Be Part of Something Built for You
                    </h2>

                    <p>
                        Join a platform that brings dating, chat, community, and
                        care together — built by people who understand why that
                        matters.
                    </p>

                    <a href="/register" class="as-about-cta-button">

                        Join AffirmSpace Free

                    </a>

                </div>

            </div>

        </section>


    </div>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document
                .querySelectorAll('.as-about-faq-question')
                .forEach(function(question) {

                    question.addEventListener('click', function() {

                        const answer = question.nextElementSibling;

                        if (!answer) {
                            return;
                        }

                        const isActive =
                            question.classList.contains('active');

                        /*
                         * Close all other FAQs
                         */
                        document
                            .querySelectorAll('.as-about-faq-question')
                            .forEach(function(otherQuestion) {

                                if (otherQuestion !== question) {

                                    otherQuestion.classList.remove('active');

                                    const otherAnswer =
                                        otherQuestion.nextElementSibling;

                                    if (otherAnswer) {
                                        otherAnswer.style.maxHeight = null;
                                    }

                                }

                            });


                        /*
                         * Toggle selected FAQ
                         */
                        if (isActive) {

                            question.classList.remove('active');
                            answer.style.maxHeight = null;

                        } else {

                            question.classList.add('active');
                            answer.style.maxHeight =
                                answer.scrollHeight + 'px';

                        }

                    });

                });

        });
    </script>
@endsection
