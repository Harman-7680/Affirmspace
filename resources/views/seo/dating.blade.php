@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Meet LGBTQ+ people looking for real connection — not just a swipe. Set your identity, your visibility, and find matches who already understand you.">

    <title>AffirmSpace – LGBTQ+ Dating App for Real Connections</title>

    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ dating, LGBTQ+ dating app, LGBTQ dating platform, gay dating app, lesbian dating app, bisexual dating, transgender dating, non-binary dating, queer dating, LGBTQ+ relationships, safe LGBTQ+ dating">

    <link rel="canonical" href="https://affirmspace.com/lgbtq-dating-app">

    <meta property="og:title" content="AffirmSpace – LGBTQ+ Dating App for Real Connections">
    <meta property="og:description"
        content="Meet LGBTQ+ people looking for real connection — not just a swipe. Set your identity, your visibility, and find matches who already understand you.">
    <meta property="og:url" content="https://affirmspace.com/lgbtq-dating-app">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="AffirmSpace">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="AffirmSpace – LGBTQ+ Dating App for Real Connections">
    <meta name="twitter:description"
        content="Meet LGBTQ+ people looking for real connection — not just a swipe. Set your identity, your visibility, and find matches who already understand you.">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    {{-- WebPage Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "AffirmSpace – LGBTQ+ Dating App for Real Connections",
        "url": "https://affirmspace.com/lgbtq-dating-app",
        "description": "Meet LGBTQ+ people looking for real connection — not just a swipe. Set your identity, your visibility, and find matches who already understand you.",
        "isPartOf": {
            "@type": "WebSite",
            "name": "AffirmSpace",
            "url": "https://affirmspace.com"
        },
        "publisher": {
            "@type": "Organization",
            "name": "AffirmSpace",
            "url": "https://affirmspace.com"
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
                "name": "Do I have to be out to use AffirmSpace Dating?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "No. You choose your visibility level — fully public, or semi-anonymous until you're ready to reveal more. You're never required to be more visible than you're comfortable with."
                }
            },

            {
                "@type": "Question",
                "name": "How does matching work?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "You set what you're looking for — friendship, dating, or a relationship — and browse or get matched with people looking for the same thing."
                }
            },

            {
                "@type": "Question",
                "name": "Is verification required to use AffirmSpace Dating?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "No. ID verification is optional. You can use AffirmSpace Dating without completing ID verification. If you choose to verify, you can receive a Verified badge for additional confidence when connecting with other members."
                }
            },

            {
                "@type": "Question",
                "name": "Can I switch what I'm looking for later?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Yes. You can update your profile — including what you're looking for and your visibility level — anytime."
                }
            },

            {
                "@type": "Question",
                "name": "Is AffirmSpace Dating only for India?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "No. AffirmSpace was built by a team based in India but is designed for LGBTQ+ people worldwide — dating works the same way regardless of where you're located."
                }
            }

        ]
    }
    </script>
@endsection


@section('css')
    <style>
        /* =========================================================
           AFFIRMSPACE LGBTQ+ DATING PAGE
           PREMIUM LANDING PAGE DESIGN
        ========================================================= */


        /* =========================================================
           GLOBAL
        ========================================================= */

        .dating-page {
            font-family: 'Inter', sans-serif;
            color: #222;
            overflow: hidden;
        }

        .dating-page *,
        .dating-page *::before,
        .dating-page *::after {
            box-sizing: border-box;
        }

        .dating-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .dating-hero {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 10% 20%, rgba(255, 81, 47, 0.08), transparent 30%),
                radial-gradient(circle at 90% 80%, rgba(221, 36, 118, 0.10), transparent 30%),
                #fff;
            padding: 90px 0 100px;
        }

        .dating-hero::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(255, 81, 47, 0.045);
            top: -180px;
            left: -180px;
            pointer-events: none;
        }

        .dating-hero::after {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: rgba(221, 36, 118, 0.045);
            bottom: -170px;
            right: -150px;
            pointer-events: none;
        }

        .dating-hero-grid {
            position: relative;
            z-index: 2;

            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            align-items: center;
            gap: 70px;
        }

        .dating-hero-content {
            max-width: 650px;
        }

        .dating-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 8px 15px;
            margin-bottom: 22px;

            border-radius: 30px;

            background: rgba(221, 36, 118, 0.08);
            color: #dd2476;

            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .dating-eyebrow::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .dating-hero h1 {
            margin: 0;

            font-size: clamp(42px, 5vw, 64px);
            line-height: 1.08;
            letter-spacing: -2px;
            font-weight: 800;
            color: #1f1f1f;
        }

        .dating-gradient-text {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dating-hero-description {
            max-width: 620px;
            margin: 25px 0 0;

            color: #5e5e5e;
            font-size: 18px;
            line-height: 1.75;
        }

        .dating-hero-buttons {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 32px;
        }

        .dating-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;

            padding: 15px 27px;

            border-radius: 50px;

            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff !important;

            font-size: 15px;
            font-weight: 800;
            text-decoration: none !important;

            box-shadow: 0 12px 28px rgba(221, 36, 118, 0.20);

            transition: all 0.3s ease;
        }

        .dating-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 17px 34px rgba(221, 36, 118, 0.28);
            color: #fff !important;
        }

        .dating-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 13px 25px;

            border: 1.5px solid #e6e6e6;
            border-radius: 50px;

            background: #fff;
            color: #333 !important;

            font-size: 15px;
            font-weight: 700;
            text-decoration: none !important;

            transition: all 0.3s ease;
        }

        .dating-btn-secondary:hover {
            border-color: #dd2476;
            color: #dd2476 !important;
            transform: translateY(-2px);
        }

        .dating-founding-line {
            margin-top: 17px;

            color: #777;
            font-size: 13px;
            line-height: 1.6;
        }

        .dating-hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dating-hero-image-wrap {
            position: relative;
            width: min(100%, 510px);
        }

        .dating-hero-image-wrap::before {
            content: "";
            position: absolute;
            inset: 25px -10px -15px 25px;

            border-radius: 34px;

            background: linear-gradient(135deg,
                    rgba(255, 81, 47, 0.13),
                    rgba(221, 36, 118, 0.15));

            transform: rotate(4deg);
            z-index: 0;
        }

        .dating-hero-image {
            position: relative;
            z-index: 2;

            display: block;

            width: 100%;
            max-width: 510px;

            border-radius: 30px;

            box-shadow:
                0 25px 70px rgba(0, 0, 0, 0.13),
                0 5px 20px rgba(221, 36, 118, 0.08);
        }

        .dating-floating-badge {
            position: absolute;
            z-index: 3;

            display: flex;
            align-items: center;
            gap: 10px;

            padding: 12px 16px;

            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 15px;

            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);

            color: #333;
            font-size: 13px;
            font-weight: 700;

            backdrop-filter: blur(10px);
        }

        .dating-floating-badge i {
            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;
        }

        .dating-badge-one {
            left: -25px;
            top: 17%;
        }

        .dating-badge-two {
            right: -20px;
            bottom: 12%;
        }


        /* =========================================================
           INTRODUCTION
        ========================================================= */

        .dating-intro {
            position: relative;
            padding: 105px 0;
            background: #fff;
        }

        .dating-intro-grid {
            display: grid;
            grid-template-columns: 0.75fr 1.25fr;
            gap: 80px;
            align-items: start;
        }

        .dating-section-label {
            display: inline-block;

            margin-bottom: 15px;

            color: #dd2476;

            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .dating-section-title {
            margin: 0;

            font-size: clamp(31px, 4vw, 46px);
            line-height: 1.15;
            letter-spacing: -1px;
            font-weight: 800;
            color: #222;
        }

        .dating-intro-copy p {
            margin: 0 0 20px;

            color: #5d5d5d;
            font-size: 17px;
            line-height: 1.85;
        }

        .dating-intro-copy p:last-child {
            margin-bottom: 0;
        }


        /* =========================================================
           FEATURE SECTION
        ========================================================= */

        .dating-features-section {
            position: relative;
            padding: 110px 0;

            background:
                radial-gradient(circle at 5% 10%, rgba(255, 81, 47, 0.05), transparent 25%),
                radial-gradient(circle at 95% 90%, rgba(221, 36, 118, 0.06), transparent 25%),
                #f9f9fb;
        }

        .dating-section-heading {
            max-width: 760px;
            margin: 0 auto 55px;
            text-align: center;
        }

        .dating-section-heading p {
            max-width: 650px;
            margin: 18px auto 0;

            color: #6a6a6a;
            font-size: 16px;
            line-height: 1.7;
        }

        .dating-feature-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
        }

        .dating-feature-card {
            position: relative;

            grid-column: span 2;

            padding: 32px 28px;

            background: #fff;
            border: 1px solid #ededed;
            border-radius: 22px;

            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.035);

            transition: all 0.35s ease;
            overflow: hidden;
        }

        .dating-feature-card:nth-child(4) {
            grid-column: 2 / span 2;
        }

        .dating-feature-card:nth-child(5) {
            grid-column: 4 / span 2;
        }

        .dating-feature-card::before {
            content: "";

            position: absolute;
            top: 0;
            left: 0;

            width: 100%;
            height: 4px;

            background: linear-gradient(90deg, #ff512f, #dd2476);

            transform: scaleX(0);
            transform-origin: left;

            transition: transform 0.35s ease;
        }

        .dating-feature-card:hover {
            transform: translateY(-7px);

            border-color: rgba(221, 36, 118, 0.16);

            box-shadow: 0 20px 45px rgba(221, 36, 118, 0.09);
        }

        .dating-feature-card:hover::before {
            transform: scaleX(1);
        }

        .dating-feature-icon {
            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 22px;

            border-radius: 17px;

            background: linear-gradient(135deg,
                    rgba(255, 81, 47, 0.10),
                    rgba(221, 36, 118, 0.11));

            color: #dd2476;

            font-size: 22px;
        }

        .dating-feature-card h3 {
            margin: 0 0 12px;

            color: #222;

            font-size: 19px;
            line-height: 1.35;
            font-weight: 800;
        }

        .dating-feature-card p {
            margin: 0;

            color: #666;

            font-size: 14.5px;
            line-height: 1.75;
        }


        /* =========================================================
           COMMUNITY STRIP
        ========================================================= */

        .dating-community {
            position: relative;
            overflow: hidden;

            padding: 110px 0;

            background: #fff;
        }

        .dating-community::before {
            content: "";

            position: absolute;

            width: 450px;
            height: 450px;

            border-radius: 50%;

            background: rgba(221, 36, 118, 0.045);

            top: -250px;
            right: -150px;
        }

        .dating-community-grid {
            position: relative;
            z-index: 2;

            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 80px;
            align-items: center;
        }

        .dating-community-heading h2 {
            margin: 0;

            color: #222;

            font-size: clamp(32px, 4vw, 46px);
            line-height: 1.15;
            letter-spacing: -1px;
            font-weight: 800;
        }

        .dating-community-heading h2 span {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dating-community-copy p {
            margin: 0;

            color: #5f5f5f;

            font-size: 17px;
            line-height: 1.85;
        }


        /* =========================================================
           WHY AFFIRMSPACE
        ========================================================= */

        .dating-why {
            padding: 110px 0;

            background:
                linear-gradient(180deg,
                    #fafafa 0%,
                    #fff 100%);
        }

        .dating-why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 55px;
        }

        .dating-why-card {
            position: relative;

            padding: 38px 30px;

            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 22px;

            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.035);

            transition: all 0.35s ease;
        }

        .dating-why-card:hover {
            transform: translateY(-7px);

            border-color: rgba(221, 36, 118, 0.18);

            box-shadow: 0 18px 45px rgba(221, 36, 118, 0.08);
        }

        .dating-why-image {
            width: 72px;
            height: 72px;

            object-fit: cover;

            margin-bottom: 22px;

            border-radius: 18px;
        }

        .dating-why-card h3 {
            margin: 0 0 13px;

            font-size: 20px;
            line-height: 1.35;
            font-weight: 800;
            color: #222;
        }

        .dating-why-card p {
            margin: 0;

            color: #666;

            font-size: 15px;
            line-height: 1.75;
        }


        /* =========================================================
           HOW IT WORKS
        ========================================================= */

        .dating-how {
            position: relative;
            overflow: hidden;

            padding: 115px 0;

            background: linear-gradient(135deg, #181818, #272027);
            color: #fff;
        }

        .dating-how::before {
            content: "";

            position: absolute;

            width: 500px;
            height: 500px;

            border-radius: 50%;

            background: rgba(255, 81, 47, 0.12);

            top: -300px;
            left: -180px;
        }

        .dating-how::after {
            content: "";

            position: absolute;

            width: 500px;
            height: 500px;

            border-radius: 50%;

            background: rgba(221, 36, 118, 0.12);

            bottom: -320px;
            right: -180px;
        }

        .dating-how-inner {
            position: relative;
            z-index: 2;
        }

        .dating-how .dating-section-heading h2 {
            color: #fff;
        }

        .dating-how .dating-section-heading p {
            color: rgba(255, 255, 255, 0.72);
        }

        .dating-steps {
            position: relative;

            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;

            margin-top: 65px;
        }

        .dating-steps::before {
            content: "";

            position: absolute;

            top: 31px;
            left: 11%;
            right: 11%;

            height: 1px;

            background: rgba(255, 255, 255, 0.18);
        }

        .dating-step {
            position: relative;
            z-index: 2;

            text-align: center;
            padding: 0 15px;
        }

        .dating-step-number {
            width: 64px;
            height: 64px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 25px;

            border-radius: 50%;

            background: linear-gradient(90deg, #ff512f, #dd2476);

            color: #fff;

            font-size: 19px;
            font-weight: 800;

            box-shadow: 0 10px 30px rgba(221, 36, 118, 0.25);

            border: 5px solid #272027;
        }

        .dating-step h3 {
            margin: 0 0 10px;

            color: #fff;

            font-size: 18px;
            line-height: 1.35;
            font-weight: 800;
        }

        .dating-step p {
            margin: 0;

            color: rgba(255, 255, 255, 0.70);

            font-size: 14px;
            line-height: 1.7;
        }


        /* =========================================================
           FAQ
        ========================================================= */

        .dating-faq {
            padding: 110px 0;

            background: #fafafa;
        }

        .dating-faq-container {
            max-width: 900px;
            margin: 55px auto 0;

            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .dating-faq-item {
            background: #fff;

            border: 1px solid #eeeeee;
            border-radius: 17px;

            overflow: hidden;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.035);

            transition: all 0.3s ease;
        }

        .dating-faq-item:hover {
            border-color: rgba(221, 36, 118, 0.18);

            box-shadow: 0 12px 32px rgba(221, 36, 118, 0.07);
        }

        .dating-faq-question {
            width: 100%;

            min-height: 72px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 20px 24px;

            border: 0;
            outline: none;

            background: #fff;

            color: #222;

            font-family: inherit;
            font-size: 16px;
            font-weight: 750;

            line-height: 1.5;
            text-align: left;

            cursor: pointer;

            transition: all 0.3s ease;
        }

        .dating-faq-question:hover {
            color: #dd2476;
        }

        .dating-faq-question::after {
            content: "+";

            flex-shrink: 0;

            width: 37px;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #fff1f5;
            color: #dd2476;

            font-size: 23px;
            font-weight: 400;

            transition: all 0.3s ease;
        }

        .dating-faq-question.active {
            color: #dd2476;
        }

        .dating-faq-question.active::after {
            content: "−";

            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;

            transform: rotate(180deg);
        }

        .dating-faq-answer {
            max-height: 0;

            overflow: hidden;

            background: #fff;

            transition: max-height 0.35s ease;
        }

        .dating-faq-answer p {
            margin: 0;

            padding: 0 75px 25px 24px;

            color: #666;

            font-size: 15px;
            line-height: 1.8;
        }

        .dating-faq-item:has(.dating-faq-question.active) {
            border-color: rgba(221, 36, 118, 0.20);

            box-shadow: 0 12px 35px rgba(221, 36, 118, 0.08);
        }


        /* =========================================================
           CROSS NAVIGATION
        ========================================================= */

        .dating-explore-more {
            padding: 105px 0;

            background: #fff;
        }

        .dating-explore-heading {
            max-width: 720px;
            margin: 0 auto 45px;

            text-align: center;
        }

        .dating-explore-heading h2 {
            margin: 0;

            font-size: clamp(30px, 4vw, 43px);
            line-height: 1.2;
            font-weight: 800;
            color: #222;
        }

        .dating-explore-heading p {
            margin: 16px auto 0;

            color: #666;
            font-size: 16px;
            line-height: 1.7;
        }

        .dating-explore-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 17px;
        }

        .dating-explore-card {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            min-height: 105px;

            padding: 22px;

            border: 1px solid #eeeeee;
            border-radius: 18px;

            background: #fff;

            color: #222 !important;
            text-decoration: none !important;

            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.035);

            transition: all 0.3s ease;
        }

        .dating-explore-card:hover {
            transform: translateY(-5px);

            border-color: rgba(221, 36, 118, 0.20);

            box-shadow: 0 15px 35px rgba(221, 36, 118, 0.08);

            color: #222 !important;
        }

        .dating-explore-card-content {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .dating-explore-icon {
            flex-shrink: 0;

            width: 46px;
            height: 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background: linear-gradient(135deg,
                    rgba(255, 81, 47, 0.10),
                    rgba(221, 36, 118, 0.10));

            color: #dd2476;

            font-size: 18px;
        }

        .dating-explore-card h3 {
            margin: 0 0 4px;

            color: #222;

            font-size: 15px;
            font-weight: 800;
        }

        .dating-explore-card span {
            color: #777;

            font-size: 12px;
            line-height: 1.4;
        }

        .dating-explore-arrow {
            flex-shrink: 0;

            color: #dd2476;

            font-size: 17px;

            transition: transform 0.3s ease;
        }

        .dating-explore-card:hover .dating-explore-arrow {
            transform: translateX(4px);
        }


        /* =========================================================
           FINAL CTA
        ========================================================= */

        .dating-final-cta {
            position: relative;
            overflow: hidden;

            padding: 100px 20px;

            background: linear-gradient(90deg, #ff512f, #dd2476);

            color: #fff;

            text-align: center;
        }

        .dating-final-cta::before {
            content: "";

            position: absolute;

            width: 430px;
            height: 430px;

            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 50%;

            top: -280px;
            left: -150px;
        }

        .dating-final-cta::after {
            content: "";

            position: absolute;

            width: 500px;
            height: 500px;

            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 50%;

            bottom: -330px;
            right: -180px;
        }

        .dating-final-cta-inner {
            position: relative;
            z-index: 2;

            max-width: 750px;
            margin: 0 auto;
        }

        .dating-final-cta h2 {
            margin: 0;

            color: #fff;

            font-size: clamp(35px, 5vw, 52px);
            line-height: 1.15;
            letter-spacing: -1px;
            font-weight: 800;
        }

        .dating-final-cta p {
            max-width: 600px;

            margin: 17px auto 0;

            color: rgba(255, 255, 255, 0.92);

            font-size: 18px;
            line-height: 1.7;
        }

        .dating-final-cta .dating-btn-primary {
            margin-top: 30px;

            background: #fff;
            color: #dd2476 !important;

            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.16);
        }

        .dating-final-cta .dating-btn-primary:hover {
            color: #dd2476 !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.22);
        }

        .dating-final-secondary-link {
            display: block;

            margin-top: 17px;

            color: #fff !important;

            font-size: 14px;
            font-weight: 700;

            text-decoration: underline !important;
        }


        /* =========================================================
           RESPONSIVE — 1100px
        ========================================================= */

        @media (max-width: 1100px) {

            .dating-hero-grid {
                gap: 45px;
            }

            .dating-feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dating-feature-card,
            .dating-feature-card:nth-child(4),
            .dating-feature-card:nth-child(5) {
                grid-column: auto;
            }

            .dating-explore-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }


        /* =========================================================
           RESPONSIVE — 900px
        ========================================================= */

        @media (max-width: 900px) {

            .dating-hero {
                padding: 70px 0 80px;
            }

            .dating-hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .dating-hero-content {
                max-width: 750px;
                margin: 0 auto;
            }

            .dating-hero-description {
                margin-left: auto;
                margin-right: auto;
            }

            .dating-hero-buttons {
                justify-content: center;
            }

            .dating-founding-line {
                text-align: center;
            }

            .dating-hero-visual {
                max-width: 570px;
                margin: 0 auto;
            }

            .dating-intro-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .dating-community-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .dating-why-grid {
                grid-template-columns: 1fr;
            }

            .dating-steps {
                grid-template-columns: repeat(2, 1fr);
                gap: 50px 20px;
            }

            .dating-steps::before {
                display: none;
            }

        }


        /* =========================================================
           RESPONSIVE — 640px
        ========================================================= */

        @media (max-width: 640px) {

            .dating-container {
                padding-left: 17px;
                padding-right: 17px;
            }

            .dating-hero {
                padding: 55px 0 65px;
            }

            .dating-hero h1 {
                font-size: 39px;
                letter-spacing: -1.3px;
            }

            .dating-hero-description {
                font-size: 16px;
                line-height: 1.7;
            }

            .dating-hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .dating-btn-primary,
            .dating-btn-secondary {
                width: 100%;
                max-width: 320px;
            }

            .dating-floating-badge {
                display: none;
            }

            .dating-intro,
            .dating-features-section,
            .dating-community,
            .dating-why,
            .dating-how,
            .dating-faq,
            .dating-explore-more {
                padding: 75px 0;
            }

            .dating-section-heading {
                margin-bottom: 40px;
            }

            .dating-section-title {
                font-size: 31px;
            }

            .dating-intro-copy p,
            .dating-community-copy p {
                font-size: 15.5px;
            }

            .dating-feature-grid {
                grid-template-columns: 1fr;
            }

            .dating-feature-card,
            .dating-feature-card:nth-child(4),
            .dating-feature-card:nth-child(5) {
                grid-column: auto;
            }

            .dating-feature-card {
                padding: 28px 23px;
            }

            .dating-community-heading h2 {
                font-size: 33px;
            }

            .dating-steps {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .dating-faq-container {
                margin-top: 40px;
            }

            .dating-faq-question {
                min-height: 65px;
                padding: 17px 18px;
                font-size: 14.5px;
                gap: 12px;
            }

            .dating-faq-question::after {
                width: 32px;
                height: 32px;
                font-size: 21px;
            }

            .dating-faq-answer p {
                padding: 0 18px 21px;

                font-size: 14px;
                line-height: 1.7;
            }

            .dating-explore-grid {
                grid-template-columns: 1fr;
            }

            .dating-explore-card {
                min-height: 90px;
            }

            .dating-final-cta {
                padding: 75px 20px;
            }

            .dating-final-cta h2 {
                font-size: 36px;
            }

            .dating-final-cta p {
                font-size: 16px;
            }

        }
    </style>
@endsection


@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <div class="dating-page">


        {{-- =====================================================
         HERO
    ====================================================== --}}

        <section class="dating-hero">

            <div class="dating-container">

                <div class="dating-hero-grid">

                    <div class="dating-hero-content">

                        <div class="dating-eyebrow">
                            LGBTQ+ Dating
                        </div>

                        <h1>
                            LGBTQ+ Dating —
                            <span class="dating-gradient-text">
                                Real Connections,
                            </span>
                            Built on Understanding
                        </h1>

                        <p class="dating-hero-description">
                            Discover people who understand you, without having to explain yourself first.
                            Set your pronouns and identity, choose how visible you want to be, and match
                            with people looking for the same thing you are.
                        </p>

                        <div class="dating-hero-buttons">

                            <a href="{{ 'register' }}?role=0" class="dating-btn-primary">
                                Create Your Profile
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>

                            <a href="{{ 'login' }}" class="dating-btn-secondary">
                                Sign In
                            </a>

                        </div>

                        <p class="dating-founding-line">
                            Early, real, and growing. Join as a founding member and help shape what this
                            community becomes.
                        </p>

                    </div>


                    <div class="dating-hero-visual">

                        <div class="dating-hero-image-wrap">

                            <img src="{{ asset('images/dating/datingheader.png') }}"
                                alt="LGBTQ+ couple representing love, dating and meaningful relationships on AffirmSpace."
                                class="dating-hero-image">

                            <div class="dating-floating-badge dating-badge-one">
                                <i class="fa-solid fa-heart"></i>
                                <span>Built around identity</span>
                            </div>

                            <div class="dating-floating-badge dating-badge-two">
                                <i class="fa-solid fa-user-shield"></i>
                                <span>Your visibility, your choice</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         WHAT IS AFFIRMSPACE DATING
    ====================================================== --}}

        <section class="dating-intro">

            <div class="dating-container">

                <div class="dating-intro-grid">

                    <div>

                        <span class="dating-section-label">
                            What Is AffirmSpace Dating?
                        </span>

                        <h2 class="dating-section-title">
                            Dating starts with being understood.
                        </h2>

                    </div>


                    <div class="dating-intro-copy">

                        <p>
                            AffirmSpace Dating is built for gay, lesbian, bisexual, transgender,
                            non-binary, pansexual, and asexual people — and anyone still figuring
                            it out — who want dating that starts from being understood, not from
                            justifying who you are.
                        </p>

                        <p>
                            Dating as an LGBTQ+ person often means starting every conversation with
                            an explanation. AffirmSpace skips that part. Your profile leads with
                            your identity, not around it, so the people you match with already know
                            who you are before the first message.
                        </p>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         DATING FEATURES
    ====================================================== --}}

        <section class="dating-features-section">

            <div class="dating-container">

                <div class="dating-section-heading">

                    <span class="dating-section-label">
                        Dating Features
                    </span>

                    <h2 class="dating-section-title">
                        Dating built around <span class="dating-gradient-text">who you are.</span>
                    </h2>

                    <p>
                        AffirmSpace gives LGBTQ+ users more control over identity, visibility,
                        what they're looking for, and who they choose to connect with.
                    </p>

                </div>


                <div class="dating-feature-grid">


                    {{-- FEATURE 1 --}}

                    <div class="dating-feature-card">

                        <div class="dating-feature-icon">
                            <i class="fa-solid fa-id-card"></i>
                        </div>

                        <h3>
                            Profiles Built for LGBTQ+ Identity
                        </h3>

                        <p>
                            Set your pronouns, your identity, and what you're looking for —
                            fields designed for LGBTQ+ users, not bolted onto a straight
                            dating app template.
                        </p>

                    </div>


                    {{-- FEATURE 2 --}}

                    <div class="dating-feature-card">

                        <div class="dating-feature-icon">
                            <i class="fa-solid fa-eye"></i>
                        </div>

                        <h3>
                            Visibility, Your Way
                        </h3>

                        <p>
                            Choose a fully public profile, or stay semi-anonymous until
                            you decide someone's worth being more visible to. Change your
                            visibility level anytime.
                        </p>

                    </div>


                    {{-- FEATURE 3 --}}

                    <div class="dating-feature-card">

                        <div class="dating-feature-icon">
                            <i class="fa-solid fa-sliders"></i>
                        </div>

                        <h3>
                            Matching Based on What You're Actually Looking For
                        </h3>

                        <p>
                            Tell AffirmSpace what you want — friendship, dating, or a
                            relationship — and see people looking for the same thing,
                            not a one-size-fits-all match pool.
                        </p>

                    </div>


                    {{-- FEATURE 4 --}}

                    <div class="dating-feature-card">

                        <div class="dating-feature-icon">
                            <i class="fa-solid fa-comments"></i>
                        </div>

                        <h3>
                            Message Once You Match
                        </h3>

                        <p>
                            No cold messages from people you haven't matched with.
                            Conversations open up once there's mutual interest, keeping
                            your inbox to people actually worth talking to.
                        </p>

                    </div>


                    {{-- FEATURE 5 --}}

                    <div class="dating-feature-card">

                        <div class="dating-feature-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <h3>
                            Optional ID Verification
                        </h3>

                        <p>
                            Verify with a photo ID for a "Verified" badge if you want
                            extra confidence in who you're talking to — never required,
                            always your choice.
                        </p>

                    </div>


                </div>

            </div>

        </section>



        {{-- =====================================================
         BUILT FOR LGBTQ+ COMMUNITY
    ====================================================== --}}

        <section class="dating-community">

            <div class="dating-container">

                <div class="dating-community-grid">

                    <div class="dating-community-heading">

                        <span class="dating-section-label">
                            More Than Dating
                        </span>

                        <h2>
                            Built for the
                            <span>LGBTQ+ Community.</span>
                        </h2>

                    </div>


                    <div class="dating-community-copy">

                        <p>
                            AffirmSpace is designed to be more than just a dating platform.
                            It's a community where LGBTQ+ individuals can connect freely,
                            express themselves openly, and build meaningful relationships
                            without fear of judgment — whether someone identifies as gay,
                            lesbian, queer, trans, non-binary, pansexual, or asexual.
                        </p>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         WHY CHOOSE AFFIRMSPACE
    ====================================================== --}}

        <section class="dating-why">

            <div class="dating-container">

                <div class="dating-section-heading">

                    <span class="dating-section-label">
                        Why AffirmSpace?
                    </span>

                    <h2 class="dating-section-title">
                        A dating experience designed
                        <span class="dating-gradient-text">for you.</span>
                    </h2>

                </div>


                <div class="dating-why-grid">


                    {{-- WHY 1 --}}

                    <div class="dating-why-card">

                        <img src="{{ asset('images/dating/Datingspace.png') }}" class="dating-why-image"
                            alt="Shield with rainbow heart representing a safe LGBTQ+ dating space.">

                        <h3>
                            Safe LGBTQ+ Dating Space
                        </h3>

                        <p>
                            Meet people who respect your identity and values in an environment
                            built around that from the start — not a mainstream dating app with
                            an LGBTQ+ filter added on.
                        </p>

                    </div>


                    {{-- WHY 2 --}}

                    <div class="dating-why-card">

                        <img src="{{ asset('images/dating/Authentication.png') }}" class="dating-why-image"
                            alt="Person inside a shield with a checkmark representing authentic profiles.">

                        <h3>
                            Authentic Profiles
                        </h3>

                        <p>
                            Every profile is built around real identity fields, not a generic
                            template — so you're meeting people as they actually identify,
                            not guessing.
                        </p>

                    </div>


                    {{-- WHY 3 --}}

                    <div class="dating-why-card">

                        <img src="{{ asset('images/dating/Connections.png') }}" class="dating-why-image"
                            alt="Two hands holding a heart representing meaningful LGBTQ+ connections.">

                        <h3>
                            Meaningful Connections
                        </h3>

                        <p>
                            Whether you're looking for friendship, dating, or a relationship,
                            AffirmSpace is built to help you find people looking for the same
                            thing, not just the nearest match.
                        </p>

                    </div>


                </div>

            </div>

        </section>



        {{-- =====================================================
         HOW AFFIRMSPACE DATING WORKS
    ====================================================== --}}

        <section class="dating-how">

            <div class="dating-container dating-how-inner">

                <div class="dating-section-heading">

                    <span class="dating-section-label">
                        Simple by Design
                    </span>

                    <h2 class="dating-section-title">
                        How AffirmSpace Dating Works
                    </h2>

                    <p>
                        Create your profile, tell us what you're looking for,
                        discover people who fit, and start talking when there's
                        mutual interest.
                    </p>

                </div>


                <div class="dating-steps">


                    {{-- STEP 1 --}}

                    <div class="dating-step">

                        <div class="dating-step-number">
                            01
                        </div>

                        <h3>
                            Create Your Account
                        </h3>

                        <p>
                            Sign up and set up your profile in minutes, with identity
                            and pronoun fields built in from the start.
                        </p>

                    </div>


                    {{-- STEP 2 --}}

                    <div class="dating-step">

                        <div class="dating-step-number">
                            02
                        </div>

                        <h3>
                            Choose Your Vibe
                        </h3>

                        <p>
                            Tell AffirmSpace what you're looking for — friendship,
                            dating, or a relationship — so your matches actually
                            reflect that.
                        </p>

                    </div>


                    {{-- STEP 3 --}}

                    <div class="dating-step">

                        <div class="dating-step-number">
                            03
                        </div>

                        <h3>
                            Discover &amp; Connect
                        </h3>

                        <p>
                            Browse profiles of people looking for the same thing
                            you are and discover potential connections.
                        </p>

                    </div>


                    {{-- STEP 4 --}}

                    <div class="dating-step">

                        <div class="dating-step-number">
                            04
                        </div>

                        <h3>
                            Chat, Connect &amp; Grow
                        </h3>

                        <p>
                            Message your matches once there's mutual interest,
                            and build something real at your own pace.
                        </p>

                    </div>


                </div>

            </div>

        </section>



        {{-- =====================================================
         FAQ
    ====================================================== --}}

        <section class="dating-faq">

            <div class="dating-container">

                <div class="dating-section-heading">

                    <span class="dating-section-label">
                        Frequently Asked Questions
                    </span>

                    <h2 class="dating-section-title">
                        Questions about LGBTQ+ Dating?
                    </h2>

                    <p>
                        Here are answers to some of the things people ask before
                        creating their profile.
                    </p>

                </div>


                <div class="dating-faq-container">


                    {{-- FAQ 1 --}}

                    <div class="dating-faq-item">

                        <button class="dating-faq-question" type="button">
                            Do I have to be out to use AffirmSpace Dating?
                        </button>

                        <div class="dating-faq-answer">

                            <p>
                                No. You choose your visibility level — fully public,
                                or semi-anonymous until you're ready to reveal more.
                                You're never required to be more visible than you're
                                comfortable with.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 2 --}}

                    <div class="dating-faq-item">

                        <button class="dating-faq-question" type="button">
                            How does matching work?
                        </button>

                        <div class="dating-faq-answer">

                            <p>
                                You set what you're looking for — friendship, dating,
                                or a relationship — and browse or get matched with
                                people looking for the same thing.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 3 --}}

                    <div class="dating-faq-item">

                        <button class="dating-faq-question" type="button">
                            Is verification required to use AffirmSpace Dating?
                        </button>

                        <div class="dating-faq-answer">

                            <p>
                                No. ID verification is optional. You can use AffirmSpace
                                Dating without completing ID verification. If you choose
                                to verify, you can receive a Verified badge for additional
                                confidence when connecting with other members.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 4 --}}

                    <div class="dating-faq-item">

                        <button class="dating-faq-question" type="button">
                            Can I switch what I'm looking for later?
                        </button>

                        <div class="dating-faq-answer">

                            <p>
                                Yes. You can update your profile — including what you're
                                looking for and your visibility level — anytime.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 5 --}}

                    <div class="dating-faq-item">

                        <button class="dating-faq-question" type="button">
                            Is AffirmSpace Dating only for India?
                        </button>

                        <div class="dating-faq-answer">

                            <p>
                                No. AffirmSpace was built by a team based in India but
                                is designed for LGBTQ+ people worldwide — dating works
                                the same way regardless of where you're located.
                            </p>

                        </div>

                    </div>


                </div>

            </div>

        </section>



        {{-- =====================================================
         LOOKING FOR SOMETHING MORE SPECIFIC
    ====================================================== --}}

        <section class="dating-explore-more">

            <div class="dating-container">

                <div class="dating-explore-heading">

                    <span class="dating-section-label">
                        Explore AffirmSpace
                    </span>

                    <h2>
                        Looking for Something
                        <span class="dating-gradient-text">More Specific?</span>
                    </h2>

                    <p>
                        Dating is only one part of AffirmSpace. Explore the other
                        spaces built to help you connect, talk, find support,
                        and meet people in the real world.
                    </p>

                </div>


                <div class="dating-explore-grid">


                    {{-- CHAT --}}

                    <a href="{{ route('chat') }}" class="dating-explore-card">

                        <div class="dating-explore-card-content">

                            <div class="dating-explore-icon">
                                <i class="fa-solid fa-comments"></i>
                            </div>

                            <div>

                                <h3>
                                    Want to talk before you match?
                                </h3>

                                <span>
                                    Explore LGBTQ+ Chat
                                </span>

                            </div>

                        </div>

                        <div class="dating-explore-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>

                    </a>


                    {{-- COUNSELLING --}}

                    <a href="{{ route('counselling') }}" class="dating-explore-card">

                        <div class="dating-explore-card-content">

                            <div class="dating-explore-icon">
                                <i class="fa-solid fa-heart-pulse"></i>
                            </div>

                            <div>

                                <h3>
                                    Need professional support?
                                </h3>

                                <span>
                                    Find an LGBTQ+-friendly counsellor
                                </span>

                            </div>

                        </div>

                        <div class="dating-explore-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>

                    </a>


                    {{-- EVENTS --}}

                    <a href="{{ route('events') }}" class="dating-explore-card">

                        <div class="dating-explore-card-content">

                            <div class="dating-explore-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>

                            <div>

                                <h3>
                                    Want to meet people in person?
                                </h3>

                                <span>
                                    See upcoming LGBTQ+ Events
                                </span>

                            </div>

                        </div>

                        <div class="dating-explore-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>

                    </a>


                    {{-- COMMUNITY --}}

                    <a href="{{ route('community') }}" class="dating-explore-card">

                        <div class="dating-explore-card-content">

                            <div class="dating-explore-icon">
                                <i class="fa-solid fa-people-group"></i>
                            </div>

                            <div>

                                <h3>
                                    Looking for groups and discussions?
                                </h3>

                                <span>
                                    Explore the Community
                                </span>

                            </div>

                        </div>

                        <div class="dating-explore-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>

                    </a>


                </div>

            </div>

        </section>



        {{-- =====================================================
         FINAL CTA
    ====================================================== --}}

        <section class="dating-final-cta">

            <div class="dating-final-cta-inner">

                <h2>
                    Start Your Journey Today
                </h2>

                <p>
                    Join AffirmSpace and meet people who already understand you.
                </p>

                <a href="{{ 'register' }}?role=0" class="dating-btn-primary">
                    Create Your Profile
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a href="{{ route('chat') }}" class="dating-final-secondary-link">
                    Explore LGBTQ+ Chat →
                </a>

            </div>

        </section>


    </div>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            ========================================================
            FAQ ACCORDION
            ========================================================
            */

            const questions = document.querySelectorAll('.dating-faq-question');

            questions.forEach(function(question) {

                question.addEventListener('click', function() {

                    const answer = question.nextElementSibling;

                    if (!answer) {
                        return;
                    }

                    const isActive = question.classList.contains('active');


                    /*
                    Close all other FAQ items
                    */

                    questions.forEach(function(otherQuestion) {

                        if (otherQuestion !== question) {

                            otherQuestion.classList.remove('active');

                            const otherAnswer = otherQuestion.nextElementSibling;

                            if (otherAnswer) {
                                otherAnswer.style.maxHeight = null;
                            }

                        }

                    });


                    /*
                    Toggle clicked FAQ
                    */

                    if (isActive) {

                        question.classList.remove('active');

                        answer.style.maxHeight = null;

                    } else {

                        question.classList.add('active');

                        answer.style.maxHeight = answer.scrollHeight + 'px';

                    }

                });

            });


        });
    </script>
@endsection
