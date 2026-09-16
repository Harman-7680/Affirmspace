@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Host an LGBTQ+ event on AffirmSpace, or browse events near you. Events show on the website and in the app, filterable by area.">

    <title>AffirmSpace – Host & Find LGBTQ+ Events Near You</title>

    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ events, LGBTQ+ events near me, LGBTQ+ meetups, LGBTQ+ community events, LGBTQ+ gatherings, LGBTQ+ events platform">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:title" content="AffirmSpace – Host & Find LGBTQ+ Events Near You">
    <meta property="og:description"
        content="Host an LGBTQ+ event on AffirmSpace, or browse events near you. Events show on the website and in the app, filterable by area.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="AffirmSpace – Host & Find LGBTQ+ Events Near You">
    <meta name="twitter:description" content="Host an LGBTQ+ event on AffirmSpace, or browse events near you.">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Inter Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- SEO Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "AffirmSpace – Host & Find LGBTQ+ Events Near You",
        "description": "Host an LGBTQ+ event on AffirmSpace, or browse events near you. Events show on the website and in the app, filterable by area.",
        "url": "{{ url()->current() }}",
        "publisher": {
            "@type": "Organization",
            "name": "AffirmSpace",
            "url": "{{ url('/') }}"
        }
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
                "name": "How do I host an event on AffirmSpace?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Create your event with the details — what, where, when — and pay the listing fee to make it live. It appears on the AffirmSpace website and app."
                }
            },
            {
                "@type": "Question",
                "name": "How much does it cost to host an event?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "The event listing fee is [INSERT ACTUAL EVENT HOSTING PRICE]."
                }
            },
            {
                "@type": "Question",
                "name": "How does area-based browsing work?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Events can be browsed according to the area-selection system available on AffirmSpace. [CONFIRM WHETHER THIS IS CITY-BASED, RADIUS-BASED, OR ANOTHER METHOD.]"
                }
            },
            {
                "@type": "Question",
                "name": "What happens to an event after it ends?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "The event is automatically removed from listings once the event date passes. You don't need to take it down yourself."
                }
            },
            {
                "@type": "Question",
                "name": "Will my event show up on both the website and the app?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Yes. Once your event is live, it is visible on both the AffirmSpace website and app."
                }
            },
            {
                "@type": "Question",
                "name": "Is AffirmSpace only for India?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "No. AffirmSpace was built by a team based in India but is designed for LGBTQ+ people worldwide."
                }
            }
        ]
    }
    </script>
@endsection


@section('css')
    <style>
        /* =========================================================
           GLOBAL
        ========================================================= */

        .events-page {
            font-family: 'Inter', sans-serif;
            color: #222;
            overflow: hidden;
        }

        .events-container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .events-section {
            padding: 90px 0;
        }

        .events-section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 30px;
            background: #fff1f5;
            color: #dd2476;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .events-section-title {
            margin: 0;
            font-size: 40px;
            line-height: 1.2;
            font-weight: 800;
            color: #222;
        }

        .events-section-subtitle {
            max-width: 700px;
            margin: 16px auto 0;
            color: #666;
            font-size: 16px;
            line-height: 1.75;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .events-hero {
            position: relative;
            background:
                radial-gradient(circle at 10% 20%, rgba(255, 81, 47, 0.08), transparent 32%),
                radial-gradient(circle at 90% 20%, rgba(221, 36, 118, 0.10), transparent 35%),
                #fff9fb;
            padding: 95px 0 110px;
        }

        .events-hero-grid {
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            align-items: center;
            gap: 70px;
        }

        .events-hero-content {
            max-width: 650px;
        }

        .events-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 16px;
            border-radius: 30px;
            background: rgba(255, 255, 255, .9);
            border: 1px solid rgba(221, 36, 118, .12);
            color: #dd2476;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 22px;
            box-shadow: 0 8px 25px rgba(221, 36, 118, .06);
        }

        .events-eyebrow i {
            font-size: 13px;
        }

        .events-hero h1 {
            margin: 0;
            font-size: clamp(42px, 5vw, 64px);
            line-height: 1.08;
            letter-spacing: -1.8px;
            font-weight: 800;
            color: #202020;
        }

        .events-hero h1 span {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .events-hero-description {
            max-width: 610px;
            margin: 24px 0 0;
            color: #5f5f5f;
            font-size: 18px;
            line-height: 1.75;
        }

        .events-hero-buttons {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 32px;
        }

        .events-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 52px;
            padding: 0 25px;
            border-radius: 14px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff !important;
            text-decoration: none !important;
            font-size: 15px;
            font-weight: 700;
            box-shadow: 0 12px 28px rgba(221, 36, 118, .20);
            transition: .3s ease;
        }

        .events-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(221, 36, 118, .26);
        }

        .events-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 52px;
            padding: 0 25px;
            border-radius: 14px;
            background: #fff;
            border: 1px solid #e5e5e5;
            color: #333 !important;
            text-decoration: none !important;
            font-size: 15px;
            font-weight: 700;
            transition: .3s ease;
        }

        .events-btn-secondary:hover {
            transform: translateY(-2px);
            border-color: rgba(221, 36, 118, .25);
            color: #dd2476 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
        }

        .events-trust-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px 24px;
            margin-top: 30px;
            color: #666;
            font-size: 13px;
            font-weight: 600;
        }

        .events-trust-row span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .events-trust-row i {
            color: #dd2476;
            font-size: 13px;
        }

        .events-hero-image {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .events-hero-image::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: linear-gradient(135deg,
                    rgba(255, 81, 47, .10),
                    rgba(221, 36, 118, .10));
            filter: blur(2px);
            z-index: 0;
        }

        .events-hero-image img {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 550px;
            height: auto;
            object-fit: contain;
        }


        /* =========================================================
           INTRO
        ========================================================= */

        .events-intro {
            background: #fff;
            text-align: center;
            padding: 85px 0 55px;
        }

        .events-intro-text {
            max-width: 800px;
            margin: 18px auto 0;
            color: #666;
            font-size: 17px;
            line-height: 1.8;
        }


        /* =========================================================
           HOW IT WORKS
        ========================================================= */

        .events-how {
            background: #fafafa;
        }

        .events-heading-center {
            text-align: center;
        }

        .events-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 48px;
        }

        .events-step {
            position: relative;
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 20px;
            padding: 30px 24px;
            min-height: 245px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, .04);
            transition: .3s ease;
        }

        .events-step:hover {
            transform: translateY(-5px);
            border-color: rgba(221, 36, 118, .20);
            box-shadow: 0 15px 35px rgba(221, 36, 118, .08);
        }

        .events-step-number {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #ddd;
            font-size: 28px;
            font-weight: 800;
        }

        .events-step-icon {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: #fff1f5;
            color: #dd2476;
            font-size: 21px;
            margin-bottom: 22px;
        }

        .events-step h3 {
            margin: 0 0 10px;
            font-size: 18px;
            font-weight: 750;
            color: #222;
        }

        .events-step p {
            margin: 0;
            color: #666;
            font-size: 14px;
            line-height: 1.7;
        }

        .events-price-note {
            margin-top: 30px;
            padding: 16px 20px;
            border-radius: 14px;
            background: #fff7f9;
            border: 1px dashed rgba(221, 36, 118, .25);
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
        }

        .events-price-note strong {
            color: #dd2476;
        }


        /* =========================================================
           EXPLORE MORE
        ========================================================= */

        .events-explore {
            background: #fff;
        }

        .events-explore-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 48px;
        }

        .events-explore-card {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 20px;
            padding: 28px 24px;
            text-decoration: none !important;
            color: inherit !important;
            min-height: 285px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, .04);
            transition: .3s ease;
        }

        .events-explore-card:hover {
            transform: translateY(-5px);
            border-color: rgba(221, 36, 118, .20);
            box-shadow: 0 15px 35px rgba(221, 36, 118, .09);
        }

        .events-explore-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: #fff1f5;
            color: #dd2476;
            font-size: 22px;
            margin-bottom: 22px;
        }

        .events-explore-card h3 {
            margin: 0 0 10px;
            color: #222;
            font-size: 18px;
            font-weight: 750;
        }

        .events-explore-card p {
            margin: 0;
            color: #666;
            font-size: 14px;
            line-height: 1.7;
            flex: 1;
        }

        .events-explore-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 20px;
            color: #dd2476;
            font-size: 14px;
            font-weight: 700;
        }


        /* =========================================================
           COMMUNITY SECTION
        ========================================================= */

        .events-community {
            background:
                radial-gradient(circle at 10% 50%, rgba(255, 81, 47, .07), transparent 30%),
                radial-gradient(circle at 90% 50%, rgba(221, 36, 118, .07), transparent 30%),
                #fafafa;
        }

        .events-community-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 70px;
        }

        .events-community-content {
            max-width: 560px;
        }

        .events-community-content h2 {
            margin: 0 0 18px;
            font-size: 40px;
            line-height: 1.2;
            font-weight: 800;
        }

        .events-community-content p {
            margin: 0;
            color: #666;
            font-size: 16px;
            line-height: 1.8;
        }

        .events-benefits {
            list-style: none;
            padding: 0;
            margin: 25px 0 30px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .events-benefits li {
            display: flex;
            align-items: center;
            gap: 11px;
            color: #444;
            font-size: 15px;
            font-weight: 600;
        }

        .events-benefits i {
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff1f5;
            color: #dd2476;
            font-size: 11px;
        }

        .events-community-image {
            display: flex;
            justify-content: center;
        }

        .events-community-image img {
            width: 100%;
            max-width: 480px;
            height: auto;
        }


        /* =========================================================
           HOST EVENT
        ========================================================= */

        .events-host {
            background: #fff;
        }

        .events-host-box {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            gap: 50px;
            padding: 55px;
            border-radius: 28px;
            background: linear-gradient(135deg,
                    #fff4f7,
                    #fff9fb);
            border: 1px solid rgba(221, 36, 118, .10);
        }

        .events-host-box h2 {
            margin: 0 0 16px;
            font-size: 36px;
            line-height: 1.2;
            font-weight: 800;
        }

        .events-host-box p {
            max-width: 600px;
            margin: 0;
            color: #666;
            font-size: 16px;
            line-height: 1.8;
        }

        .events-host-image {
            display: flex;
            justify-content: center;
        }

        .events-host-image img {
            width: 100%;
            max-width: 350px;
        }


        /* =========================================================
           FAQ
        ========================================================= */

        .events-faq {
            background: #fafafa;
        }

        .events-faq-container {
            max-width: 950px;
            margin: 48px auto 0;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .events-faq-item {
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .04);
            transition: .3s ease;
        }

        .events-faq-item:hover {
            border-color: rgba(221, 36, 118, .18);
            box-shadow: 0 10px 30px rgba(221, 36, 118, .08);
        }

        .events-faq-question {
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
        }

        .events-faq-question:hover {
            color: #dd2476;
        }

        .events-faq-question::after {
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
            transition: .3s ease;
        }

        .events-faq-question.active::after {
            content: "−";
            color: #fff;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            transform: rotate(180deg);
        }

        .events-faq-answer {
            max-height: 0;
            overflow: hidden;
            background: #fff;
            transition: max-height .35s ease;
        }

        .events-faq-answer p {
            margin: 0;
            padding: 0 70px 24px 24px;
            color: #666;
            font-size: 15px;
            line-height: 1.75;
        }


        /* =========================================================
           CROSS NAVIGATION
        ========================================================= */

        .events-more {
            background: #fff;
        }

        .events-more-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-top: 45px;
        }

        .events-more-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 20px;
            border-radius: 16px;
            background: #fff;
            border: 1px solid #eeeeee;
            text-decoration: none !important;
            color: #333 !important;
            font-size: 14px;
            font-weight: 700;
            transition: .3s ease;
        }

        .events-more-card i {
            color: #dd2476;
            transition: .3s ease;
        }

        .events-more-card:hover {
            transform: translateY(-3px);
            border-color: rgba(221, 36, 118, .20);
            box-shadow: 0 10px 25px rgba(221, 36, 118, .07);
            color: #dd2476 !important;
        }

        .events-more-card:hover i {
            transform: translateX(4px);
        }


        /* =========================================================
           FINAL CTA
        ========================================================= */

        .events-final-cta {
            padding: 30px 0 90px;
            background: #fff;
        }

        .events-final-box {
            position: relative;
            overflow: hidden;
            padding: 70px 50px;
            border-radius: 28px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;
            text-align: center;
            box-shadow: 0 20px 50px rgba(221, 36, 118, .18);
        }

        .events-final-box::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            top: -150px;
            left: -100px;
        }

        .events-final-box::after {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07);
            bottom: -140px;
            right: -70px;
        }

        .events-final-content {
            position: relative;
            z-index: 2;
        }

        .events-final-box h2 {
            margin: 0 0 12px;
            font-size: 42px;
            line-height: 1.2;
            font-weight: 800;
        }

        .events-final-box p {
            margin: 0 auto 28px;
            max-width: 650px;
            color: rgba(255, 255, 255, .92);
            font-size: 17px;
            line-height: 1.7;
        }

        .events-final-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .events-final-primary {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 14px 25px;
            border-radius: 13px;
            background: #fff;
            color: #dd2476 !important;
            text-decoration: none !important;
            font-size: 15px;
            font-weight: 750;
            transition: .3s ease;
        }

        .events-final-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .12);
        }

        .events-final-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 20px;
            color: #fff !important;
            text-decoration: none !important;
            font-size: 15px;
            font-weight: 700;
            transition: .3s ease;
        }

        .events-final-secondary:hover {
            transform: translateY(-2px);
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1050px) {

            .events-steps,
            .events-explore-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .events-more-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .events-hero-grid,
            .events-community-grid,
            .events-host-box {
                gap: 45px;
            }
        }


        @media (max-width: 800px) {

            .events-section {
                padding: 70px 0;
            }

            .events-hero {
                padding: 70px 0 80px;
            }

            .events-hero-grid,
            .events-community-grid,
            .events-host-box {
                grid-template-columns: 1fr;
            }

            .events-hero-content {
                max-width: 100%;
                text-align: center;
            }

            .events-hero-description {
                margin-left: auto;
                margin-right: auto;
            }

            .events-hero-buttons,
            .events-trust-row {
                justify-content: center;
            }

            .events-hero-image {
                order: -1;
            }

            .events-hero-image img {
                max-width: 430px;
            }

            .events-community-content {
                max-width: 100%;
            }

            .events-community-image {
                order: -1;
            }

            .events-host-box {
                padding: 40px 25px;
                text-align: center;
            }

            .events-host-box p {
                margin-left: auto;
                margin-right: auto;
            }
        }


        @media (max-width: 600px) {

            .events-container {
                width: min(100% - 28px, 1180px);
            }

            .events-section-title,
            .events-community-content h2 {
                font-size: 31px;
            }

            .events-hero h1 {
                font-size: 39px;
                letter-spacing: -1px;
            }

            .events-hero-description {
                font-size: 16px;
            }

            .events-hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .events-btn-primary,
            .events-btn-secondary {
                width: 100%;
            }

            .events-trust-row {
                flex-direction: column;
                gap: 10px;
            }

            .events-steps,
            .events-explore-grid,
            .events-more-grid {
                grid-template-columns: 1fr;
            }

            .events-step {
                min-height: auto;
            }

            .events-final-box {
                padding: 55px 22px;
                border-radius: 22px;
            }

            .events-final-box h2 {
                font-size: 32px;
            }

            .events-final-box p {
                font-size: 15px;
            }

            .events-final-buttons {
                flex-direction: column;
            }

            .events-final-primary,
            .events-final-secondary {
                width: 100%;
                justify-content: center;
            }

            .events-faq-question {
                min-height: 65px;
                padding: 17px 18px;
                font-size: 15px;
            }

            .events-faq-answer p {
                padding: 0 18px 20px;
                font-size: 14px;
            }
        }
    </style>
@endsection


@section('content')
    <div class="events-page">


        {{-- =====================================================
         HERO
    ====================================================== --}}

        <section class="events-hero">

            <div class="events-container">

                <div class="events-hero-grid">

                    <div class="events-hero-content">

                        <div class="events-eyebrow">
                            <i class="fa-solid fa-calendar-days"></i>
                            LGBTQ+ Events & Community
                        </div>

                        <h1>
                            LGBTQ+ Events & Meetups,
                            <span>Hosted by the Community</span>
                        </h1>

                        <p class="events-hero-description">
                            Host a meetup, workshop, or gathering and it goes live on
                            AffirmSpace's website and app. Browse events near you,
                            filtered by area, whenever you're looking for something to join.
                        </p>

                        <div class="events-hero-buttons">

                            <a href="{{ 'register' }}?role=0" class="events-btn-primary">
                                <i class="fa-solid fa-calendar-plus"></i>
                                Host an Event
                            </a>

                            <a href="#events-browse" class="events-btn-secondary">
                                <i class="fa-solid fa-location-dot"></i>
                                Browse Events by Area
                            </a>

                        </div>

                        <div class="events-trust-row">

                            <span>
                                <i class="fa-solid fa-check"></i>
                                Safe & Inclusive
                            </span>

                            <span>
                                <i class="fa-solid fa-check"></i>
                                Community Driven
                            </span>

                            <span>
                                <i class="fa-solid fa-check"></i>
                                Online & Offline
                            </span>

                        </div>

                    </div>


                    <div class="events-hero-image">

                        <img src="{{ asset('images/events/eventop.png') }}"
                            alt="LGBTQ+ community celebrating together at an event">

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
         INTRO
    ====================================================== --}}

        <section class="events-intro">

            <div class="events-container">

                <span class="events-section-label">
                    <i class="fa-solid fa-people-group"></i>
                    Events on AffirmSpace
                </span>

                <h2 class="events-section-title">
                    Find Something Worth Showing Up For
                </h2>

                <p class="events-intro-text">
                    AffirmSpace gives the LGBTQ+ community a place to discover and
                    share experiences beyond the screen. Host a meetup, workshop,
                    gathering, or online event — or browse what's happening around
                    your area and find something that feels right for you.
                </p>

            </div>

        </section>


        {{-- =====================================================
         HOW IT WORKS
    ====================================================== --}}

        <section class="events-section events-how" id="events-browse">

            <div class="events-container">

                <div class="events-heading-center">

                    <span class="events-section-label">
                        <i class="fa-solid fa-list-check"></i>
                        How It Works
                    </span>

                    <h2 class="events-section-title">
                        From Idea to Community Event
                    </h2>

                    <p class="events-section-subtitle">
                        Hosting an event on AffirmSpace is designed to be simple:
                        create your listing, publish it, and let people in your
                        area discover it.
                    </p>

                </div>


                <div class="events-steps">

                    {{-- STEP 1 --}}
                    <div class="events-step">

                        <span class="events-step-number">01</span>

                        <div class="events-step-icon">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>

                        <h3>Create Your Event</h3>

                        <p>
                            Add the details: what it is, where and when it takes
                            place, and whether it's online or in person.
                        </p>

                    </div>


                    {{-- STEP 2 --}}
                    <div class="events-step">

                        <span class="events-step-number">02</span>

                        <div class="events-step-icon">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>

                        <h3>Pay to List It</h3>

                        <p>
                            A listing fee puts your event live on AffirmSpace.
                            The actual hosting price is shown during the event
                            creation process.
                        </p>

                    </div>


                    {{-- STEP 3 --}}
                    <div class="events-step">

                        <span class="events-step-number">03</span>

                        <div class="events-step-icon">
                            <i class="fa-solid fa-globe"></i>
                        </div>

                        <h3>Go Live on the Website and App</h3>

                        <p>
                            Your event appears on the AffirmSpace website and app,
                            visible to people browsing events in the relevant area.
                        </p>

                    </div>


                    {{-- STEP 4 --}}
                    <div class="events-step">

                        <span class="events-step-number">04</span>

                        <div class="events-step-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>

                        <h3>Automatically Removed When It's Over</h3>

                        <p>
                            Once the event date passes, it's cleared from listings.
                            No manual cleanup is needed on your end.
                        </p>

                    </div>

                </div>

                <!--
                <div class="events-price-note">

                    <strong>Event listing fee:</strong>
                    [INSERT YOUR ACTUAL EVENT HOSTING PRICE HERE]

                </div> -->

            </div>

        </section>


        {{-- =====================================================
         EXPLORE MORE
    ====================================================== --}}

        <section class="events-section events-explore">

            <div class="events-container">

                <div class="events-heading-center">

                    <span class="events-section-label">
                        <i class="fa-solid fa-compass"></i>
                        Explore More on AffirmSpace
                    </span>

                    <h2 class="events-section-title">
                        More Ways to Connect
                    </h2>

                    <p class="events-section-subtitle">
                        Looking for connection beyond events? AffirmSpace has more
                        ways to meet people, learn, talk, and find support.
                    </p>

                </div>


                <div class="events-explore-grid">


                    {{-- ARTICLES --}}
                    <a href="{{ route('blogs') }}" class="events-explore-card">

                        <div class="events-explore-icon">
                            <i class="fa-solid fa-book-open"></i>
                        </div>

                        <h3>Read Helpful Articles</h3>

                        <p>
                            Learn more about mental health, relationships, identity,
                            and personal growth from guides written for real
                            questions, not generic advice.
                        </p>

                        <span class="events-explore-link">
                            Browse Articles
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>

                    </a>


                    {{-- COMMUNITY --}}
                    <a href="{{ route('chat') }}" class="events-explore-card">

                        <div class="events-explore-icon">
                            <i class="fa-solid fa-comments"></i>
                        </div>

                        <h3>Connect in the Community</h3>

                        <p>
                            Join LGBTQ+ discussions and meet people in chat rooms
                            organized around identity and topic.
                        </p>

                        <span class="events-explore-link">
                            Join Chat
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>

                    </a>


                    {{-- SUPPORT --}}
                    <a href="{{ route('counselling') }}" class="events-explore-card">

                        <div class="events-explore-icon">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>

                        <h3>Find Support Resources</h3>

                        <p>
                            Get guidance from LGBTQ+-friendly counsellors whenever
                            you need professional support.
                        </p>

                        <span class="events-explore-link">
                            Find Support
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>

                    </a>


                    {{-- HOST --}}
                    <a href="{{ 'register' }}?role=0" class="events-explore-card">

                        <div class="events-explore-icon">
                            <i class="fa-solid fa-calendar-plus"></i>
                        </div>

                        <h3>Host Your Own Event</h3>

                        <p>
                            Have an idea for a meetup, workshop, or gathering?
                            Set it up and make it visible to people browsing
                            events in your area.
                        </p>

                        <span class="events-explore-link">
                            Host an Event
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>

                    </a>

                </div>

            </div>

        </section>


        {{-- =====================================================
         COMMUNITY
    ====================================================== --}}

        <section class="events-section events-community">

            <div class="events-container">

                <div class="events-community-grid">

                    <div class="events-community-content">

                        <span class="events-section-label">
                            <i class="fa-solid fa-heart"></i>
                            Community Connection
                        </span>

                        <h2>
                            Be Part of the Community
                        </h2>

                        <p>
                            Discover experiences that inspire, connect, and
                            empower the LGBTQ+ community. Whether you're attending
                            your first meetup or organizing something of your own,
                            events can turn online connections into real-world
                            experiences.
                        </p>

                        <ul class="events-benefits">

                            <li>
                                <i class="fa-solid fa-check"></i>
                                Meet New People
                            </li>

                            <li>
                                <i class="fa-solid fa-check"></i>
                                Build Friendships
                            </li>

                            <li>
                                <i class="fa-solid fa-check"></i>
                                Celebrate Diversity
                            </li>

                        </ul>

                        <a href="{{ 'register' }}?role=0" class="events-btn-primary">
                            Host or Browse Events
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>


                    <div class="events-community-image">

                        <img src="{{ asset('images/events/eventfooter.png') }}"
                            alt="Calendar representing LGBTQ+ community events">

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
         HOST YOUR OWN EVENT
    ====================================================== --}}

        <section class="events-section events-host">

            <div class="events-container">

                <div class="events-host-box">

                    <div>

                        <span class="events-section-label">
                            <i class="fa-solid fa-calendar-plus"></i>
                            Create Something
                        </span>

                        <h2>
                            Have an Idea for a Meetup?
                        </h2>

                        <p>
                            Host a meetup, workshop, gathering, or online event
                            and make it discoverable to people looking for LGBTQ+
                            experiences in your area.
                        </p>

                        <div style="margin-top:28px;">

                            <a href="{{ 'register' }}?role=0" class="events-btn-primary">
                                Host an Event
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>

                        </div>

                    </div>


                    <div class="events-host-image">

                        <img src="{{ asset('images/events/e1.png') }}" alt="Community event illustration">

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
         FAQ
    ====================================================== --}}

        <section class="events-section events-faq">

            <div class="events-container">

                <div class="events-heading-center">

                    <span class="events-section-label">
                        <i class="fa-solid fa-circle-question"></i>
                        Frequently Asked Questions
                    </span>

                    <h2 class="events-section-title">
                        Questions About LGBTQ+ Events?
                    </h2>

                    <p class="events-section-subtitle">
                        Here's what you need to know about hosting and discovering
                        events on AffirmSpace.
                    </p>

                </div>


                <div class="events-faq-container">


                    {{-- FAQ 1 --}}
                    <div class="events-faq-item">

                        <button type="button" class="events-faq-question">
                            How do I host an event on AffirmSpace?
                        </button>

                        <div class="events-faq-answer">

                            <p>
                                Create your event with the details — what, where,
                                and when — and pay the listing fee to make it live.
                                It appears on the AffirmSpace website and app.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 2 --}}
                    <div class="events-faq-item">

                        <button type="button" class="events-faq-question">
                            How much does it cost to host an event?
                        </button>

                        <div class="events-faq-answer">

                            <p>
                                The event listing fee is
                                <strong>[INSERT ACTUAL EVENT HOSTING PRICE]</strong>.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 3 --}}
                    <div class="events-faq-item">

                        <button type="button" class="events-faq-question">
                            How does area-based browsing work?
                        </button>

                        <div class="events-faq-answer">

                            <p>
                                Events can be browsed according to the area
                                selection available on AffirmSpace.
                                <strong>
                                    [CONFIRM WHETHER YOUR SYSTEM IS CITY-BASED,
                                    RADIUS-BASED, OR ANOTHER METHOD.]
                                </strong>
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 4 --}}
                    <div class="events-faq-item">

                        <button type="button" class="events-faq-question">
                            What happens to an event after it ends?
                        </button>

                        <div class="events-faq-answer">

                            <p>
                                It's automatically removed from listings once the
                                event date passes. You don't need to take it down
                                yourself.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 5 --}}
                    <div class="events-faq-item">

                        <button type="button" class="events-faq-question">
                            Will my event show up on both the website and the app?
                        </button>

                        <div class="events-faq-answer">

                            <p>
                                Yes. Once your event is live, it's visible in both
                                places — on the AffirmSpace website and app.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 6 --}}
                    <div class="events-faq-item">

                        <button type="button" class="events-faq-question">
                            Is AffirmSpace only for India?
                        </button>

                        <div class="events-faq-answer">

                            <p>
                                No. AffirmSpace was built by a team based in India
                                but is designed for LGBTQ+ people worldwide.
                                You can host or browse events from anywhere.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
         CROSS NAVIGATION
    ====================================================== --}}

        <section class="events-section events-more">

            <div class="events-container">

                <div class="events-heading-center">

                    <span class="events-section-label">
                        <i class="fa-solid fa-layer-group"></i>
                        Looking for Something More Specific?
                    </span>

                    <h2 class="events-section-title">
                        There's More to Explore
                    </h2>

                </div>


                <div class="events-more-grid">

                    <a href="{{ route('chat') }}" class="events-more-card">
                        <span>Want to talk to people today? Explore LGBTQ+ Chat</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <a href="{{ route('chatAndDating') }}" class="events-more-card">
                        <span>Looking for dating or friendship? Explore LGBTQ+ Dating</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <a href="{{ route('counselling') }}" class="events-more-card">
                        <span>Need professional support? Find an LGBTQ+-friendly counsellor</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <a href="{{ route('community') }}" class="events-more-card">
                        <span>Want groups and discussions? Explore the Community</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>

        </section>


        {{-- =====================================================
         FINAL CTA
    ====================================================== --}}

        <section class="events-final-cta">

            <div class="events-container">

                <div class="events-final-box">

                    <div class="events-final-content">

                        <h2>
                            Bring People Together
                        </h2>

                        <p>
                            Host an event, or find one worth showing up for.
                            Connect with the LGBTQ+ community through experiences
                            that happen both online and offline.
                        </p>

                        <div class="events-final-buttons">

                            <a href="{{ 'register' }}?role=0" class="events-final-primary">
                                Host an Event
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>

                            <a href="#events-browse" class="events-final-secondary">
                                Browse Events by Area
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>


    </div>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.events-faq-question').forEach(function(question) {

                question.addEventListener('click', function() {

                    const answer = question.nextElementSibling;

                    question.classList.toggle('active');

                    if (!answer) return;

                    if (answer.style.maxHeight) {
                        answer.style.maxHeight = null;
                    } else {
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                    }

                });

            });

        });
    </script>
@endsection
