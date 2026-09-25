@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AffirmSpace – LGBTQ+ Dating, Chat, Community & Care</title>

    <meta name="description"
        content="AffirmSpace connects LGBTQ+ people worldwide through dating, chat, community, and gender-affirming healthcare — all built by a team who gets it.">

    <meta name="keywords"
        content="LGBTQ+ dating, LGBTQ+ dating app, LGBTQ+ chat, LGBTQ+ community, LGBTQ+ social network, LGBTQ+ events, LGBTQ+ counselling, gender-affirming healthcare, gay dating, lesbian dating, bisexual dating, transgender dating, non-binary dating, queer community">

    <meta name="author" content="AffirmSpace">

    <meta property="og:title" content="AffirmSpace – LGBTQ+ Dating, Chat, Community & Care">

    <meta property="og:description"
        content="AffirmSpace connects LGBTQ+ people worldwide through dating, chat, community, and gender-affirming healthcare.">

    <meta property="og:type" content="website">

    <meta property="og:url" content="{{ config('app.url') }}">

    <meta property="og:image" content="{{ config('app.url') . '/images/og.png' }}">

    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="AffirmSpace – LGBTQ+ Dating, Chat, Community & Care">

    <meta name="twitter:description" content="Dating, chat, community and LGBTQ+-friendly care in one place.">

    <meta name="twitter:image" content="{{ config('app.url') . '/images/og.png' }}">

    <link rel="canonical" href="{{ config('app.url') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


    {{-- Organization Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "AffirmSpace",
        "url": "https://affirmspace.com",
        "logo": "https://affirmspace.com/images/new_logo.png",
        "sameAs": [
            "https://www.instagram.com/affirmspaceofficial/",
            "https://www.facebook.com/Affirmspace/",
            "https://www.linkedin.com/in/affirm-space-6a2632400/",
            "https://x.com/affirm_space"
        ]
    }
    </script>


    {{-- Software Application Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "AffirmSpace",
        "applicationCategory": "SocialNetworkingApplication",
        "operatingSystem": "Android, iOS",
        "url": "https://affirmspace.com",
        "downloadUrl": "https://play.google.com/store/apps/details?id=com.affirmspace.app",
        "description": "AffirmSpace is an LGBTQ+ social networking platform for dating, chat, community, events and support."
    }
    </script>


    {{-- Website Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "AffirmSpace",
        "url": "https://affirmspace.com"
    }
    </script>


    {{-- FAQ Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "Is AffirmSpace a dating app, a chat app, or a community?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "AffirmSpace brings dating, chat, community and LGBTQ+-friendly healthcare provider discovery together in one platform. Each has its own dedicated space, and you can use as many or as few as you want from one account."
                }
            },
            {
                "@type": "Question",
                "name": "Is AffirmSpace only for India?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "No. AffirmSpace was built by a team based in India but is designed for LGBTQ+ people worldwide."
                }
            },
            {
                "@type": "Question",
                "name": "Does AffirmSpace provide medical treatment?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "No. AffirmSpace does not provide medical advice or treatment. It helps users discover LGBTQ+-friendly counsellors and gender-affirming care providers. Care itself happens directly between the user and the provider."
                }
            },
            {
                "@type": "Question",
                "name": "Is AffirmSpace free to join?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "AffirmSpace is currently available for users to join. Any feature limits, paid services or future pricing will be communicated clearly on the platform."
                }
            }
        ]
    }
    </script>
@endsection

@section('css')
    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            color: #222;
            background: #fff;
        }

        img {
            max-width: 100%;
            display: block;
        }

        a {
            text-decoration: none;
        }

        #splash-screen {
            position: fixed;
            inset: 0;
            background-color: #dafaf8ff;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            font-size: 2rem;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        #splash-screen img {
            width: 150px;
            margin-bottom: 20px;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0%,
            50%,
            100% {
                transform: scale(1);
            }

            25%,
            75% {
                transform: scale(1.3);
            }
        }

        /* Mobile */
        @media (max-width: 600px) {
            .app-availability {
                min-height: 42px;
                padding: 7px 10px;
                font-size: 12px;
            }
        }

        .section {
            padding: 90px 6%;
        }

        .section-heading {
            max-width: 850px;
            margin: 0 auto 55px;
            text-align: center;
        }

        .section-heading h2 {
            margin: 0 0 18px;
            font-size: clamp(32px, 4vw, 48px);
            line-height: 1.15;
            font-weight: 800;
            color: #181818;
        }

        .section-heading p {
            margin: 0;
            color: #666;
            font-size: 17px;
            line-height: 1.7;
        }

        .primary-btn {
            display: inline-block;
            padding: 15px 31px;
            border-radius: 50px;
            color: #fff;
            font-weight: 700;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .primary-btn:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(221, 36, 118, 0.25);
        }

        .secondary-btn {
            display: inline-block;
            padding: 13px 28px;
            border: 2px solid #dd2476;
            border-radius: 50px;
            color: #dd2476;
            font-weight: 700;
            transition: all 0.25s ease;
        }

        .secondary-btn:hover {
            color: #fff;
            border-color: transparent;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .split-hero {
            width: 100%;
            min-height: 680px;
            display: flex;
            align-items: center;
            gap: 60px;
            padding: 80px 6%;
            background: #fff;
        }

        .split-hero-content {
            width: 50%;
        }

        .split-hero-content h1 {
            margin: 0 0 25px;
            color: #171717;
            font-size: clamp(38px, 5vw, 64px);
            line-height: 1.08;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .split-hero-content p {
            max-width: 680px;
            margin: 0 0 30px;
            color: #555;
            font-size: 19px;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .founding-line {
            margin: 0 !important;
            color: #666 !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
        }

        .split-hero-video {
            width: 50%;
            display: flex;
            justify-content: center;
        }

        .split-hero-video video {
            width: 100%;
            max-width: 800px;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.14);
        }


        /* =========================================
                                           WHAT IS AFFIRMSPACE
                                        ========================================= */

        .intro-section {
            background: #fafafa;
        }

        .intro-content {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }

        .intro-content h2 {
            margin: 0 0 22px;
            font-size: clamp(34px, 4vw, 48px);
            font-weight: 800;
            color: #181818;
        }

        .intro-content h2 span {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .intro-content p {
            margin: 0 0 17px;
            color: #555;
            font-size: 18px;
            line-height: 1.85;
        }

        .intro-content p:last-child {
            margin-bottom: 0;
        }

        .explore-section {
            background: #fff;
        }

        .explore-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
        }

        .explore-card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 470px;
            padding: 30px 25px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #ededed;
            border-radius: 22px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.055);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .explore-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .explore-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.10);
        }

        .explore-icon {
            width: 58px;
            height: 58px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: #fff2f5;
            font-size: 28px;
        }

        .explore-card h3 {
            margin: 0 0 12px;
            color: #1d1d1d;
            font-size: 22px;
            line-height: 1.25;
            font-weight: 800;
        }

        .explore-card>p {
            margin: 0 0 20px;
            color: #666;
            font-size: 14.5px;
            line-height: 1.65;
        }

        .explore-card h4 {
            margin: 0 0 12px;
            color: #222;
            font-size: 14px;
            font-weight: 800;
        }

        .explore-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .explore-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 11px;
            color: #555;
            font-size: 13.5px;
            line-height: 1.55;
        }

        .explore-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 0;
            font-weight: 800;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .explore-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: auto;
            padding-top: 20px;
            color: #dd2476;
            font-size: 14px;
            font-weight: 800;
        }

        .explore-link:hover {
            color: #ff512f;
        }

        .why-section {
            background: #fafafa;
        }

        .why-content {
            max-width: 950px;
            margin: 0 auto;
            text-align: center;
        }

        .why-content h2 {
            margin: 0 0 25px;
            font-size: clamp(34px, 4vw, 48px);
            font-weight: 800;
        }

        .why-content p {
            margin: 0 0 20px;
            color: #555;
            font-size: 18px;
            line-height: 1.8;
        }

        .why-content p:last-child {
            margin-bottom: 0;
        }

        .identity-section {
            min-height: 500px;
            display: flex;
            align-items: center;
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.52), rgba(0, 0, 0, 0.52)),
                url('images/beyou.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .identity-content {
            max-width: 850px;
            margin: 0 auto;
            text-align: center;
        }

        .identity-content h2 {
            margin: 0 0 20px;
            font-size: clamp(34px, 4vw, 52px);
            font-weight: 800;
        }

        .identity-content p {
            margin: 0;
            font-size: 18px;
            line-height: 1.8;
        }

        .trust-section {
            background: #fff;
        }

        .trust-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .trust-card {
            padding: 30px 25px;
            text-align: center;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        }

        .trust-card-icon {
            margin-bottom: 15px;
            font-size: 35px;
        }

        .trust-card h3 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .trust-card p {
            margin: 0;
            color: #666;
            line-height: 1.65;
        }

        .blog-section {
            background: #fafafa;
        }

        .blog-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            align-items: stretch;
            /* Sabhi cards ki height equal karne ke liye */
        }

        .blog-card {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            color: inherit;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: left !important;
            /* Left alignment force karne ke liye */
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.09);
        }

        .blog-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .blog-content {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            /* Content ko stretch karta hai taaki card pura bhare */
            text-align: left !important;
        }

        .blog-content h3 {
            margin: 0 0 12px;
            color: #222;
            font-size: 20px;
            line-height: 1.4;
            text-align: left;
        }

        .blog-content p {
            margin: 0 0 15px;
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            flex-grow: 1;
            /* Text area ko space dega taaki button niche jaye */
            text-align: left;
        }

        .blog-content span {
            color: #dd2476;
            font-size: 14px;
            font-weight: 800;
            margin-top: auto;
            /* Button ko hamesha bottom par fix karega */
            display: inline-block;
            text-align: left;
        }

        .view-guides {
            display: flex;
            justify-content: center;
            margin-top: 35px;
        }

        .how-section {
            background: #fff;
        }

        .how-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .how-card {
            padding: 30px;
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 20px;
        }

        .how-number {
            width: 45px;
            height: 45px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
            font-weight: 800;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .how-card h3 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .how-card p {
            margin: 0;
            color: #666;
            line-height: 1.65;
        }

        .faq-section {
            background: #fafafa;
        }

        .faq-container {
            max-width: 950px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .faq-item {
            background: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: rgba(221, 36, 118, 0.18);
            box-shadow: 0 10px 30px rgba(221, 36, 118, 0.08);
            transform: translateY(-2px);
        }

        .faq-question {
            width: 100%;
            min-height: 72px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            border: 0;
            background: #ffffff;

            color: #222;
            font-family: inherit;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.5;
            text-align: left;

            cursor: pointer;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            color: #dd2476;
        }

        .faq-question::after {
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

        .faq-question.active::after {
            content: "−";

            color: #ffffff;

            background: linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;

            background: #ffffff;

            transition: max-height 0.35s ease;
        }

        .faq-answer p {
            margin: 0;

            padding: 0 70px 24px 24px;

            color: #666;

            font-size: 15px;
            line-height: 1.75;
        }

        .faq-item:has(.faq-question.active) {
            border-color: rgba(221, 36, 118, 0.22);
            box-shadow: 0 12px 35px rgba(221, 36, 118, 0.09);
        }

        .faq-item:has(.faq-question.active) .faq-question {
            color: #dd2476;
        }

        @media (max-width: 600px) {

            .faq-container {
                gap: 12px;
            }

            .faq-item {
                border-radius: 14px;
            }

            .faq-question {
                min-height: 65px;
                padding: 17px 18px;

                font-size: 15px;
                gap: 12px;
            }

            .faq-question::after {
                width: 32px;
                height: 32px;

                font-size: 21px;
            }

            .faq-answer p {
                padding: 0 18px 20px;

                font-size: 14px;
                line-height: 1.7;
            }

        }

        .cta-section {
            padding: 95px 6%;
            text-align: center;
            color: #fff;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .cta-section h2 {
            margin: 0 0 18px;
            font-size: clamp(34px, 4vw, 52px);
            font-weight: 800;
        }

        .cta-section p {
            max-width: 720px;
            margin: 0 auto 30px;
            font-size: 18px;
            line-height: 1.7;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 32px;
            border-radius: 50px;
            background: #fff;
            color: #dd2476;
            font-weight: 800;
            transition: transform 0.25s ease;
        }

        .cta-button:hover {
            color: #dd2476;
            transform: translateY(-2px);
        }

        .cta-secondary {
            display: block;
            margin-top: 18px;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
        }

        .cta-secondary:hover {
            color: #fff;
            text-decoration: underline;
        }

        @media (max-width: 1200px) {

            .explore-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

        }


        @media (max-width: 900px) {

            .split-hero {
                flex-direction: column;
                padding: 60px 6%;
                text-align: center;
            }

            .split-hero-content,
            .split-hero-video {
                width: 100%;
            }

            .split-hero-content p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons {
                justify-content: center;
            }

            .trust-grid,
            .how-grid,
            .blog-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }


        @media (max-width: 600px) {

            .section {
                padding: 65px 5%;
            }

            .explore-grid,
            .trust-grid,
            .how-grid,
            .blog-grid {
                grid-template-columns: 1fr;
            }

            .explore-card {
                min-height: auto;
            }

            .split-hero {
                min-height: auto;
                padding: 45px 5%;
            }

            .split-hero-content h1 {
                font-size: 38px;
                letter-spacing: -0.8px;
            }

            .split-hero-content p {
                font-size: 16px;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .primary-btn,
            .secondary-btn {
                text-align: center;
            }

            .blog-card img {
                height: 200px;
            }

        }
    </style>
@endsection


@section('content')
    <div id="splash-screen">

        <img src="{{ asset('images/welcomepage.png') }}" alt="AffirmSpace">

    </div>

    <!-- <div class="app-availability">

                                            AffirmSpace is available on Android.

                                            <a
                                                href="https://play.google.com/store/apps/details?id=com.affirmspace.app"
                                                target="_blank"
                                                rel="noopener">

                                                Download the app

                                            </a>

                                        </div> -->


    {{-- =========================================
         HERO
    ========================================= --}}

    <section class="split-hero">

        <div class="split-hero-content">

            <h1>
                One Platform for LGBTQ+ Dating, Chat, Community & Care
            </h1>

            <p>
                Dating apps make you date. Support forums make you talk.
                Nobody puts dating, chat, community, and LGBTQ+ friendly
                healthcare in one place — until now.
            </p>

            <div class="hero-buttons">

                <a href="{{ 'register' }}?role=0" class="primary-btn">

                    Join AffirmSpace for Free

                </a>

                <a href="#explore-affirmspace" class="secondary-btn">

                    Explore What You Can Do ↓

                </a>

            </div>

            <p class="founding-line">
                Early, real, and growing. Join as a founding member and help
                shape what AffirmSpace becomes.
            </p>

        </div>


        <div class="split-hero-video">

            <video autoplay muted loop playsinline preload="metadata">

                <source src="{{ asset('images/welcome_video.mp4') }}" type="video/mp4">

                Your browser does not support the video tag.

            </video>

        </div>

    </section>

    <section class="section intro-section">

        <div class="intro-content">

            <h2>
                What Is <span>AffirmSpace?</span>
            </h2>

            <p>
                AffirmSpace is a social platform built for the global LGBTQ+
                community — a place for gay, lesbian, bisexual, transgender,
                non-binary, pansexual, and asexual people, as well as anyone
                still figuring it out, to date, chat, join a community, and
                find doctors and counsellors who understand LGBTQ+ experiences.
            </p>

            <p>
                Instead of having to use one platform for dating, another for
                conversation, another for community, and search somewhere else
                for LGBTQ+-friendly care, AffirmSpace brings these experiences
                together in one place.
            </p>

            <p>
                Built by a team based in India, AffirmSpace was created around
                a problem we kept seeing: every dating app treats you as a
                profile, every chat app treats you as a stranger, and healthcare
                discovery can leave LGBTQ+ people searching for providers who
                understand what they are dealing with.
            </p>

            <p>
                So we built one platform for LGBTQ+ people wherever they are —
                whether you are looking for a connection, a conversation,
                community, an event, or support.
            </p>

        </div>

    </section>

    <section class="section explore-section" id="explore-affirmspace">

        <div class="section-heading">

            <h2>Explore AffirmSpace</h2>

            <p>
                Dating, chat, community, events and LGBTQ+-friendly care —
                each part of AffirmSpace is designed to give you a different
                way to connect and find what you need.
            </p>

        </div>

        <div class="explore-grid">

            <article class="explore-card">

                <div class="explore-icon">
                    💛
                </div>

                <h3>
                    LGBTQ+ Dating
                </h3>

                <p>
                    Match and message gay, lesbian, bisexual, trans,
                    non-binary, pansexual, and asexual people —
                    real connection, not endless swiping.
                </p>

                <h4>
                    What you can do here:
                </h4>

                <ul class="explore-list">

                    <li>
                        Build a profile with pronoun and identity fields
                    </li>

                    <li>
                        Choose full visibility or stay anonymous until you're ready
                    </li>

                    <li>
                        Match and message directly without a hidden algorithm
                        deciding for you
                    </li>

                </ul>

                <a href="{{ url('/lgbtq-dating-app') }}" class="explore-link">

                    Explore LGBTQ+ Dating →

                </a>

            </article>

            <article class="explore-card">

                <div class="explore-icon">
                    💬
                </div>

                <h3>
                    LGBTQ+ Chat
                </h3>

                <p>
                    Private and group chats with people who already get it —
                    no dating pressure attached.
                </p>

                <h4>
                    What you can do here:
                </h4>

                <ul class="explore-list">

                    <li>
                        Chat anonymously under a username when you want more privacy
                    </li>

                    <li>
                        Join group conversations organized around identities or topics
                    </li>

                    <li>
                        Message people one-on-one in private conversations
                    </li>

                </ul>

                <a href="{{ url('/lgbtq-chat') }}" class="explore-link">

                    Explore LGBTQ+ Chat →

                </a>

            </article>

            <article class="explore-card">

                <div class="explore-icon">
                    🩺
                </div>

                <h3>
                    Mental Health & Gender-Affirming Care
                </h3>

                <p>
                    Find LGBTQ+-friendly counsellors and explore
                    gender-affirming care resources without having to
                    start your search from scratch.
                </p>

                <h4>
                    What you can do here:
                </h4>

                <ul class="explore-list">

                    <li>
                        Browse counsellor profiles, specialties and areas of focus
                    </li>

                    <li>
                        Explore consultation and counselling options
                    </li>

                    <li>
                        Find resources related to identity, HRT, relationships
                        and gender-affirming care
                    </li>

                </ul>

                <a href="{{ url('/lgbtq-mental-health-counselling') }}" class="explore-link">

                    Explore Counselling & Care →

                </a>

            </article>

            <article class="explore-card">

                <div class="explore-icon">
                    🎉
                </div>

                <h3>
                    LGBTQ+ Events
                </h3>

                <p>
                    Meetups, workshops, Pride events and LGBTQ+ experiences —
                    online and in person.
                </p>

                <h4>
                    What you can do here:
                </h4>

                <ul class="explore-list">

                    <li>
                        Discover upcoming events near you or online
                    </li>

                    <li>
                        Find new events as they are added
                    </li>

                    <li>
                        Explore events by city, topic or online availability
                    </li>

                </ul>

                <a href="{{ url('/lgbtq-events') }}" class="explore-link">

                    Explore Events →

                </a>

            </article>

            <article class="explore-card">

                <div class="explore-icon">
                    🤝
                </div>

                <h3>
                    LGBTQ+ Community
                </h3>

                <p>
                    Groups, discussions and a social feed built around
                    identity, shared experiences and interests.
                </p>

                <h4>
                    What you can do here:
                </h4>

                <ul class="explore-list">

                    <li>
                        Join groups based on identity or interest
                    </li>

                    <li>
                        Post and take part in ongoing discussions
                    </li>

                    <li>
                        Follow topics relevant to your journey
                    </li>

                </ul>

                <a href="{{ url('/lgbtq-community') }}" class="explore-link">

                    Explore Community →

                </a>

            </article>

            <article class="explore-card">

                <div class="explore-icon">
                    🕶️
                </div>

                <h3>
                    Anonymous Conversations
                </h3>

                <p>
                    A space to talk about personal experiences and topics
                    without making your public profile the focus.
                </p>

                <h4>
                    What you can do here:
                </h4>

                <ul class="explore-list">

                    <li>
                        Join temporary conversations using a random name
                    </li>

                    <li>
                        Talk around a specific topic or experience
                    </li>

                    <li>
                        Participate without putting your public profile on display
                    </li>

                </ul>

                <a href="{{ url('/lgbtq-chat') }}" class="explore-link">

                    Explore LGBTQ+ Chat →

                </a>

            </article>

            <article class="explore-card">

                <div class="explore-icon">
                    🌈
                </div>

                <h3>
                    LGBTQ+ Social Connection
                </h3>

                <p>
                    Go beyond dating and connect with people through shared
                    interests, experiences and conversations.
                </p>

                <h4>
                    What you can do here:
                </h4>

                <ul class="explore-list">

                    <li>
                        Discover people beyond dating
                    </li>

                    <li>
                        Take part in community conversations
                    </li>

                    <li>
                        Build connections around shared interests and experiences
                    </li>

                </ul>

                <a href="{{ url('/lgbtq-community') }}" class="explore-link">

                    Explore Community →

                </a>

            </article>

            <article class="explore-card">

                <div class="explore-icon">
                    💗
                </div>

                <h3>
                    LGBTQ+ Support & Resources
                </h3>

                <p>
                    Guides and information covering LGBTQ+ identities,
                    healthcare, relationships, wellbeing and topics
                    people actually search for.
                </p>

                <h4>
                    What you can do here:
                </h4>

                <ul class="explore-list">

                    <li>
                        Learn more about LGBTQ+ identities and experiences
                    </li>

                    <li>
                        Explore gender-affirming healthcare information
                    </li>

                    <li>
                        Find guides covering relationships, rights and wellbeing
                    </li>

                </ul>

                <a href="#learn-resources" class="explore-link">

                    Explore LGBTQ+ Resources →

                </a>

            </article>


        </div>

    </section>

    <section class="section why-section">

        <div class="why-content">

            <h2>
                Why AffirmSpace?
            </h2>

            <p>
                None of the major LGBTQ+ platforms combine dating, chat,
                community, and healthcare discovery in one place.
                AffirmSpace does — because we kept running into the same
                problem ourselves: no single platform treated all of these
                experiences as connected.
            </p>

            <p>
                We're not the biggest platform in this space yet.
                We're building one specifically designed to hold these
                pieces together — by a team that started from the same
                questions our members are asking.
            </p>

            <p>
                That means you don't have to choose between finding a date,
                finding people to talk to, finding your community, and finding
                support. They're all part of the same space.
            </p>

        </div>

    </section>

    <section class="section identity-section">

        <div class="identity-content">

            <h2>
                Be Yourself. Connect on Your Terms.
            </h2>

            <p>
                Your identity is yours to define. Whether you're openly
                LGBTQ+, exploring your identity, or still figuring things out,
                AffirmSpace gives you space to connect at your own pace.
            </p>

        </div>

    </section>

    <section class="section trust-section">

        <div class="section-heading">

            <h2>
                Built for Trust, Not Just Claiming It
            </h2>

            <p>
                We're building AffirmSpace around transparency, privacy and
                giving people more control over how they connect.
            </p>

        </div>


        <div class="trust-grid">


            <div class="trust-card">

                <div class="trust-card-icon">
                    🔎
                </div>

                <h3>
                    Provider Information
                </h3>

                <p>
                    Counsellor and healthcare provider profiles can give users
                    information about names, specialties and areas of focus so
                    they can make a more informed choice.
                </p>

            </div>


            <div class="trust-card">

                <div class="trust-card-icon">
                    🕶️
                </div>

                <h3>
                    Privacy Choices
                </h3>

                <p>
                    Where anonymous participation is available, you can choose
                    to interact without putting your public profile identity
                    at the centre of the conversation.
                </p>

            </div>


            <div class="trust-card">

                <div class="trust-card-icon">
                    🔒
                </div>

                <h3>
                    Your Data Matters
                </h3>

                <p>
                    Your personal information is not sold. Learn more about
                    how information is handled in our
                    <a href="{{ url('/privacy') }}" style="color:#dd2476;font-weight:700;">
                        privacy policy
                    </a>.
                </p>

            </div>


        </div>

    </section>

    <section class="section blog-section" id="learn-resources">

        <div class="section-heading">

            <h2>
                Learn, Grow & Stay Informed
            </h2>

            <p>
                Guides on LGBTQ+ identities, gender-affirming healthcare,
                relationships, legal rights and the questions people
                actually search for.
            </p>

        </div>

        <div class="blog-grid">

            @foreach ($blogs as $blog)
                <a href="{{ url('/blog/' . $blog->category . '/' . $blog->slug) }}" class="blog-card">

                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->short_description }}">

                    <div class="blog-content">

                        <h3>
                            {{ $blog->short_description }}
                        </h3>

                        <div class="blog-excerpt">
                            {!! \Illuminate\Support\Str::limit(strip_tags($blog->long_description, '<p><strong><em>'), 120, '...') !!}
                        </div>

                        <span>
                            Read More →
                        </span>

                    </div>

                </a>
            @endforeach

        </div>


        <div class="view-guides">

            <a href="{{ route('blogs') }}" class="primary-btn">

                View All Guides →

            </a>

        </div>

    </section>

    <section class="section how-section">

        <div class="section-heading">

            <h2>
                How AffirmSpace Works
            </h2>

            <p>
                Start with whichever part of the platform you need.
                You can explore dating, chat, community, events and care
                from one account.
            </p>

        </div>


        <div class="how-grid">


            <div class="how-card">

                <div class="how-number">
                    1
                </div>

                <h3>
                    Join AffirmSpace
                </h3>

                <p>
                    Create your account and decide how you want to present
                    yourself and connect with others.
                </p>

            </div>


            <div class="how-card">

                <div class="how-number">
                    2
                </div>

                <h3>
                    Choose Your Space
                </h3>

                <p>
                    Explore dating, chat, community, events or LGBTQ+-friendly
                    counselling and care discovery.
                </p>

            </div>


            <div class="how-card">

                <div class="how-number">
                    3
                </div>

                <h3>
                    Connect
                </h3>

                <p>
                    Match with people, start conversations, join groups or
                    discover events and resources.
                </p>

            </div>


            <div class="how-card">

                <div class="how-number">
                    4
                </div>

                <h3>
                    Explore at Your Pace
                </h3>

                <p>
                    Use as much or as little of AffirmSpace as you want.
                    Dating doesn't have to be your reason for being here.
                </p>

            </div>


            <div class="how-card">

                <div class="how-number">
                    5
                </div>

                <h3>
                    Find Your Community
                </h3>

                <p>
                    Discover people and conversations around identity,
                    interests and shared experiences.
                </p>

            </div>


            <div class="how-card">

                <div class="how-number">
                    6
                </div>

                <h3>
                    Find Support
                </h3>

                <p>
                    Explore educational guides, counselling and
                    gender-affirming care resources when you need them.
                </p>

            </div>


        </div>

    </section>

    <section class="section faq-section">

        <div class="section-heading">

            <h2>
                Frequently Asked Questions
            </h2>

            <p>
                Answers to some of the most common questions about AffirmSpace.
            </p>

        </div>


        <div class="faq-container">


            <div class="faq-item">

                <button class="faq-question" type="button">

                    Is AffirmSpace a dating app, a chat app, or a community?

                </button>

                <div class="faq-answer">

                    <p>
                        All three, plus LGBTQ+-friendly healthcare provider
                        discovery. Each has its own dedicated space, and you
                        can use as many or as few as you want from one account.
                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question" type="button">

                    Is AffirmSpace only for India?

                </button>

                <div class="faq-answer">

                    <p>
                        No. AffirmSpace was built by a team based in India
                        but is designed for LGBTQ+ people worldwide. The
                        platform is being built to serve LGBTQ+ people
                        wherever they are.
                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question" type="button">

                    Is AffirmSpace safe to use?

                </button>

                <div class="faq-answer">

                    <p>
                        AffirmSpace is designed with privacy, community
                        guidelines and reporting in mind. Because the platform
                        is growing, we continue to improve moderation and
                        safety systems as the community grows. Please use the
                        available reporting tools and community guidelines
                        when you encounter behaviour that violates the rules.
                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question" type="button">

                    Does AffirmSpace provide medical treatment?

                </button>

                <div class="faq-answer">

                    <p>
                        No. AffirmSpace does not provide medical advice or
                        treatment. We help users discover LGBTQ+-friendly
                        counsellors and gender-affirming care providers.
                        The care itself happens directly between you and
                        the provider.
                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question" type="button">

                    Is AffirmSpace free to join?

                </button>

                <div class="faq-answer">

                    <p>
                        AffirmSpace is currently available for users to join.
                        Any feature limits, paid services or future pricing
                        will be communicated clearly on the platform.
                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question" type="button">

                    How many people are on AffirmSpace right now?

                </button>

                <div class="faq-answer">

                    <p>
                        AffirmSpace is an early and growing community.
                        We're focused on building the right platform and
                        community rather than presenting our current size
                        as a marketing claim. Join now as a founding member
                        and help shape what AffirmSpace becomes.
                    </p>

                </div>

            </div>


        </div>

    </section>

    <section class="cta-section">

        <h2>
            Find Your People — On Your Terms
        </h2>

        <p>
            Dating, chat, community, or care — start with whichever one
            you need right now.
        </p>

        <a href="{{ 'register' }}?role=0" class="cta-button">

            Join AffirmSpace Free

        </a>

        <a href="#explore-affirmspace" class="cta-secondary">

            See what's inside →

        </a>

    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const splash = document.getElementById('splash-screen');
            if (!sessionStorage.getItem('flashShown')) {
                splash.style.display = 'flex';
                setTimeout(() => {
                    splash.style.opacity = '0';
                    setTimeout(() => {
                        splash.style.display = 'none';
                    }, 500);
                }, 1000);
                sessionStorage.setItem('flashShown', 'true');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {

            // Smooth image crossfade
            const layer1 = document.getElementById('bgLayer1');
            const layer2 = document.getElementById('bgLayer2');
            let showLayer1 = true;

            setInterval(() => {
                if (showLayer1) {
                    layer1.style.opacity = '0';
                    layer2.style.opacity = '1';
                } else {
                    layer1.style.opacity = '1';
                    layer2.style.opacity = '0';
                }
                showLayer1 = !showLayer1;
            }, 7000); // change every 7 seconds – fade takes 2 seconds
        });
    </script>

    <script>
        document
            .querySelectorAll('.faq-question')
            .forEach(function(question) {

                question.addEventListener('click', function() {

                    const answer =
                        question.nextElementSibling;

                    question.classList.toggle('active');

                    if (!answer) {
                        return;
                    }

                    if (answer.style.maxHeight) {

                        answer.style.maxHeight = null;

                    } else {

                        answer.style.maxHeight =
                            answer.scrollHeight + 'px';

                    }

                });

            });
    </script>
@endsection
