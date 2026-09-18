@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Join AffirmSpace's LGBTQ+ community — groups, discussions, and a feed built around identity and shared experience. Connect beyond dating, in a safe, respectful space.">

    <title>AffirmSpace – LGBTQ+ Community, Groups & Discussions</title>

    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ community, LGBTQ+ groups, LGBTQ+ discussions, LGBTQ+ community platform, LGBTQ+ social network, safe LGBTQ+ community, LGBTQ+ support community, LGBTQ+ online community">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection


@section('css')
    <style>
        /* =========================================================
               AFFIRMSPACE COMMUNITY PAGE
               FULL RESPONSIVE + FULLY SCOPED
            ========================================================= */

        .as-community-page {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
            color: #222;
            background: #fff;
        }

        .as-community-page *,
        .as-community-page *::before,
        .as-community-page *::after {
            box-sizing: border-box;
        }

        .as-community-page img {
            max-width: 100%;
        }

        .as-community-container {
            width: min(1200px, 92%);
            margin: 0 auto;
        }


        /* =========================================================
               HERO
            ========================================================= */

        .as-community-hero {
            position: relative;
            width: 100%;
            padding: 95px 0;
            background:
                radial-gradient(circle at 10% 20%,
                    rgba(255, 81, 47, 0.06),
                    transparent 32%),
                radial-gradient(circle at 90% 80%,
                    rgba(221, 36, 118, 0.07),
                    transparent 32%),
                #fafafa;
            overflow: hidden;
        }

        .as-community-hero::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 4px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .as-community-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            align-items: center;
            gap: 70px;
        }

        .as-community-hero-text {
            min-width: 0;
        }

        .as-community-eyebrow {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(221, 36, 118, 0.14);
            border-radius: 999px;
            background: #fff;
            color: #dd2476;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.04);
        }

        .as-community-hero-title {
            margin: 0;
            color: #151515;
            font-size: clamp(40px, 5vw, 62px);
            font-weight: 800;
            line-height: 1.06;
            letter-spacing: -2.5px;
            overflow-wrap: anywhere;
        }

        .as-community-hero-title span {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .as-community-hero-description {
            max-width: 590px;
            margin: 22px 0 0;
            color: #555;
            font-size: 17px;
            line-height: 1.8;
        }

        .as-community-hero-buttons {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .as-community-primary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            padding: 14px 30px;
            color: #fff !important;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            border-radius: 999px;
            font-size: 15px;
            font-weight: 750;
            line-height: 1.2;
            text-decoration: none !important;
            white-space: nowrap;
            box-shadow: 0 12px 28px rgba(221, 36, 118, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .as-community-primary-btn:hover {
            color: #fff !important;
            transform: translateY(-3px);
            box-shadow: 0 17px 35px rgba(221, 36, 118, 0.28);
        }

        .as-community-founding-line {
            margin: 17px 0 0;
            color: #777;
            font-size: 13px;
            line-height: 1.6;
        }

        .as-community-hero-image {
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .as-community-hero-image-wrap {
            position: relative;
            width: 100%;
            max-width: 520px;
        }

        .as-community-hero-image-wrap::before {
            content: "";
            position: absolute;
            inset: 8% 5%;
            border-radius: 35px;
            background: linear-gradient(135deg,
                    rgba(255, 81, 47, 0.11),
                    rgba(221, 36, 118, 0.11));
            filter: blur(25px);
            z-index: 0;
        }

        .as-community-hero-image img {
            position: relative;
            z-index: 1;
            display: block;
            width: 100%;
            height: auto;
            object-fit: contain;
        }


        /* =========================================================
               SHARED SECTION
            ========================================================= */

        .as-community-section {
            width: 100%;
            padding: 100px 0;
        }

        .as-community-section-light {
            background: #fafafa;
        }

        .as-community-section-white {
            background: #fff;
        }

        .as-community-section-header {
            max-width: 820px;
            margin: 0 auto 55px;
            text-align: center;
        }

        .as-community-section-label {
            display: inline-block;
            margin-bottom: 13px;
            color: #dd2476;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .as-community-section-title {
            margin: 0;
            color: #151515;
            font-size: clamp(31px, 4vw, 46px);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -1.5px;
        }

        .as-community-section-intro {
            max-width: 720px;
            margin: 18px auto 0;
            color: #666;
            font-size: 16px;
            line-height: 1.8;
        }


        /* =========================================================
               WHAT IS AFFIRMSPACE COMMUNITY
            ========================================================= */

        .as-community-about {
            padding: 100px 0;
            background: #fff;
        }

        .as-community-about-grid {
            display: grid;
            grid-template-columns: minmax(0, 0.8fr) minmax(0, 1.2fr);
            gap: 70px;
            align-items: center;
        }

        .as-community-about-title {
            margin: 0;
            color: #151515;
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.13;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .as-community-about-title span {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .as-community-about-content {
            padding: 35px 40px;
            border: 1px solid #eeeeee;
            border-radius: 25px;
            background: #fff;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.055);
        }

        .as-community-about-content p {
            margin: 0;
            color: #555;
            font-size: 16px;
            line-height: 1.9;
        }

        .as-community-about-content p+p {
            margin-top: 20px;
        }


        /* =========================================================
               COMMUNITY FEATURES
            ========================================================= */

        .as-community-features {
            padding: 100px 0;
            background: #fafafa;
        }

        .as-community-feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 25px;
        }

        .as-community-feature-card {
            position: relative;
            min-width: 0;
            padding: 35px 30px;
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                border-color 0.3s ease;
        }

        .as-community-feature-card::before {
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

        .as-community-feature-card:hover {
            transform: translateY(-7px);
            border-color: rgba(221, 36, 118, 0.18);
            box-shadow:
                0 18px 45px rgba(255, 81, 47, 0.08),
                0 12px 35px rgba(221, 36, 118, 0.08);
        }

        .as-community-feature-card:hover::before {
            transform: scaleX(1);
        }

        .as-community-feature-image {
            width: 68px;
            height: 68px;
            margin-bottom: 22px;
            border-radius: 18px;
            object-fit: cover;
        }

        .as-community-feature-card h3 {
            margin: 0 0 14px;
            color: #222;
            font-size: 20px;
            font-weight: 750;
            line-height: 1.35;
        }

        .as-community-feature-card p {
            margin: 0;
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }


        /* =========================================================
               HOW COMMUNITY WORKS
            ========================================================= */

        .as-community-steps {
            padding: 100px 0;
            background: #fff;
        }

        .as-community-steps-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 25px;
        }

        .as-community-step-card {
            position: relative;
            min-width: 0;
            padding: 35px 30px;
            border: 1px solid #eeeeee;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.045);
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .as-community-step-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);
        }

        .as-community-step-number {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            border-radius: 14px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;
            font-size: 18px;
            font-weight: 800;
        }

        .as-community-step-card h3 {
            margin: 0 0 12px;
            color: #222;
            font-size: 19px;
            line-height: 1.35;
            font-weight: 750;
        }

        .as-community-step-card p {
            margin: 0;
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }


        /* =========================================================
               WHY COMMUNITY MATTERS
            ========================================================= */

        .as-community-why {
            position: relative;
            padding: 105px 20px;
            background:
                linear-gradient(135deg,
                    #fff7f4,
                    #fff,
                    #fff5f8);
            text-align: center;
            overflow: hidden;
        }

        .as-community-why::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            left: -120px;
            top: -150px;
            border-radius: 50%;
            background: rgba(255, 81, 47, 0.08);
            filter: blur(20px);
        }

        .as-community-why::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            right: -120px;
            bottom: -150px;
            border-radius: 50%;
            background: rgba(221, 36, 118, 0.08);
            filter: blur(20px);
        }

        .as-community-why-content {
            position: relative;
            z-index: 1;
            max-width: 850px;
            margin: 0 auto;
        }

        .as-community-why-text {
            margin: 25px auto 0;
            color: #5b5b5b;
            font-size: 17px;
            line-height: 1.9;
        }


        /* =========================================================
               COMMUNITY VALUES
            ========================================================= */

        .as-community-values {
            padding: 100px 0;
            background: #fff;
        }

        .as-community-values-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .as-community-value-card {
            min-width: 0;
            min-height: 270px;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            border: 1px solid #eeeeee;
            border-radius: 20px;
            background: #fafafa;
            box-shadow: 0 7px 22px rgba(0, 0, 0, 0.035);
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                border-color 0.3s ease;
        }

        .as-community-value-card:hover {
            transform: translateY(-6px);
            border-color: rgba(221, 36, 118, 0.16);
            box-shadow: 0 15px 35px rgba(221, 36, 118, 0.08);
        }

        .as-community-value-card img {
            width: 78px;
            height: 78px;
            margin-bottom: 20px;
            object-fit: contain;
        }

        .as-community-value-card h3 {
            margin: 0 0 10px;
            color: #222;
            font-size: 17px;
            line-height: 1.4;
            font-weight: 750;
        }

        .as-community-value-card p {
            margin: 0;
            color: #666;
            font-size: 13px;
            line-height: 1.7;
        }


        /* =========================================================
               FAQ
            ========================================================= */

        .as-community-faq {
            padding: 100px 0;
            background: #fafafa;
        }

        .as-community-faq-container {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .as-community-faq-item {
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.035);
            transition: all 0.3s ease;
        }

        .as-community-faq-item:hover {
            border-color: rgba(221, 36, 118, 0.18);
            box-shadow: 0 10px 30px rgba(221, 36, 118, 0.07);
        }

        .as-community-faq-question {
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
            transition: color 0.3s ease;
        }

        .as-community-faq-question:hover {
            color: #dd2476;
        }

        .as-community-faq-question::after {
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

        .as-community-faq-question.active::after {
            content: "−";
            color: #fff;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            transform: rotate(180deg);
        }

        .as-community-faq-answer {
            max-height: 0;
            overflow: hidden;
            background: #fff;
            transition: max-height 0.35s ease;
        }

        .as-community-faq-answer p {
            margin: 0;
            padding: 0 70px 24px 24px;
            color: #666;
            font-size: 15px;
            line-height: 1.75;
        }

        .as-community-faq-item:has(.as-community-faq-question.active) {
            border-color: rgba(221, 36, 118, 0.22);
            box-shadow: 0 12px 35px rgba(221, 36, 118, 0.08);
        }

        .as-community-faq-item:has(.as-community-faq-question.active) .as-community-faq-question {
            color: #dd2476;
        }


        /* =========================================================
               EXPLORE MORE
            ========================================================= */

        .as-community-more {
            padding: 100px 0;
            background: #fff;
        }

        .as-community-more-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .as-community-more-card {
            display: flex;
            flex-direction: column;
            min-height: 215px;
            padding: 27px 23px;
            border: 1px solid #eeeeee;
            border-radius: 20px;
            background: #fff;
            text-decoration: none !important;
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                border-color 0.3s ease;
        }

        .as-community-more-card:hover {
            transform: translateY(-6px);
            border-color: rgba(221, 36, 118, 0.18);
            box-shadow: 0 15px 35px rgba(221, 36, 118, 0.08);
        }

        .as-community-more-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            border-radius: 14px;
            background: #fff1f5;
            font-size: 21px;
        }

        .as-community-more-card h3 {
            margin: 0 0 9px;
            color: #222;
            font-size: 16px;
            line-height: 1.4;
            font-weight: 750;
        }

        .as-community-more-card p {
            margin: 0;
            color: #666;
            font-size: 13px;
            line-height: 1.65;
        }

        .as-community-more-link {
            margin-top: auto;
            padding-top: 18px;
            color: #dd2476;
            font-size: 13px;
            font-weight: 750;
        }


        /* =========================================================
               FINAL CTA
            ========================================================= */

        .as-community-cta {
            width: 100%;
            padding: 105px 20px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;
            text-align: center;
        }

        .as-community-cta h2 {
            margin: 0;
            color: #fff;
            font-size: clamp(34px, 4vw, 50px);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1.2px;
        }

        .as-community-cta p {
            max-width: 680px;
            margin: 20px auto 0;
            color: rgba(255, 255, 255, 0.94);
            font-size: 17px;
            line-height: 1.75;
        }

        .as-community-cta-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            margin-top: 30px;
            padding: 14px 32px;
            color: #dd2476 !important;
            background: #fff;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 750;
            text-decoration: none !important;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.14);
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .as-community-cta-btn:hover {
            color: #dd2476 !important;
            transform: translateY(-3px);
            box-shadow: 0 17px 35px rgba(0, 0, 0, 0.2);
        }


        /* =========================================================
               TABLET
            ========================================================= */

        @media screen and (max-width: 1050px) {

            .as-community-hero-grid {
                gap: 40px;
            }

            .as-community-feature-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .as-community-steps-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .as-community-values-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .as-community-more-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }


        /* =========================================================
               MOBILE
            ========================================================= */

        @media screen and (max-width: 768px) {

            .as-community-container {
                width: min(92%, 600px);
            }

            .as-community-hero {
                padding: 65px 0 70px;
            }

            .as-community-hero-grid {
                grid-template-columns: 1fr;
                gap: 38px;
                text-align: center;
            }

            .as-community-hero-title {
                max-width: 650px;
                margin-left: auto;
                margin-right: auto;
                font-size: clamp(36px, 8vw, 48px);
                letter-spacing: -1.5px;
            }

            .as-community-hero-description {
                margin-left: auto;
                margin-right: auto;
                font-size: 15px;
            }

            .as-community-hero-buttons {
                justify-content: center;
            }

            .as-community-founding-line {
                max-width: 450px;
                margin-left: auto;
                margin-right: auto;
            }

            .as-community-hero-image {
                order: 2;
            }

            .as-community-hero-image-wrap {
                max-width: 450px;
            }

            .as-community-section,
            .as-community-about,
            .as-community-features,
            .as-community-steps,
            .as-community-values,
            .as-community-faq,
            .as-community-more {
                padding: 75px 0;
            }

            .as-community-about-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .as-community-about-title {
                text-align: center;
            }

            .as-community-about-content {
                padding: 30px;
            }

            .as-community-feature-grid,
            .as-community-steps-grid {
                grid-template-columns: 1fr;
            }

            .as-community-feature-card,
            .as-community-step-card {
                padding: 30px 24px;
            }

            .as-community-more-grid {
                grid-template-columns: 1fr;
            }

            .as-community-why {
                padding: 75px 20px;
            }

            .as-community-cta {
                padding: 80px 20px;
            }
        }


        /* =========================================================
               SMALL PHONE
            ========================================================= */

        @media screen and (max-width: 480px) {

            .as-community-container {
                width: min(92%, 500px);
            }

            .as-community-hero {
                padding: 48px 0 58px;
            }

            .as-community-eyebrow {
                padding: 7px 12px;
                font-size: 10px;
            }

            .as-community-hero-title {
                font-size: 34px;
                line-height: 1.1;
                letter-spacing: -1px;
            }

            .as-community-hero-description {
                font-size: 14px;
                line-height: 1.7;
            }

            .as-community-hero-buttons {
                width: 100%;
            }

            .as-community-primary-btn {
                width: 100%;
                min-height: 49px;
            }

            .as-community-founding-line {
                font-size: 12px;
            }

            .as-community-section,
            .as-community-about,
            .as-community-features,
            .as-community-steps,
            .as-community-values,
            .as-community-faq,
            .as-community-more {
                padding: 60px 0;
            }

            .as-community-section-header {
                margin-bottom: 35px;
            }

            .as-community-section-title,
            .as-community-about-title {
                font-size: 30px;
                letter-spacing: -0.8px;
            }

            .as-community-section-intro {
                font-size: 14px;
                line-height: 1.7;
            }

            .as-community-about-title {
                font-size: 31px;
            }

            .as-community-about-content {
                padding: 25px 21px;
                border-radius: 20px;
            }

            .as-community-about-content p {
                font-size: 14px;
                line-height: 1.8;
            }

            .as-community-feature-card,
            .as-community-step-card {
                padding: 27px 20px;
                border-radius: 18px;
            }

            .as-community-feature-card h3,
            .as-community-step-card h3 {
                font-size: 18px;
            }

            .as-community-feature-card p,
            .as-community-step-card p {
                font-size: 14px;
                line-height: 1.75;
            }

            .as-community-feature-image {
                width: 58px;
                height: 58px;
            }

            .as-community-step-number {
                width: 44px;
                height: 44px;
                font-size: 16px;
            }

            .as-community-why {
                padding: 65px 18px;
            }

            .as-community-why-text {
                font-size: 14px;
                line-height: 1.75;
            }

            .as-community-values-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .as-community-value-card {
                min-height: 220px;
                padding: 25px 20px;
            }

            .as-community-value-card img {
                width: 68px;
                height: 68px;
            }

            .as-community-faq-container {
                gap: 11px;
            }

            .as-community-faq-item {
                border-radius: 14px;
            }

            .as-community-faq-question {
                min-height: 65px;
                padding: 17px 18px;
                font-size: 14px;
                gap: 12px;
            }

            .as-community-faq-question::after {
                width: 32px;
                height: 32px;
                font-size: 21px;
            }

            .as-community-faq-answer p {
                padding: 0 18px 20px;
                font-size: 13px;
                line-height: 1.7;
            }

            .as-community-more-grid {
                grid-template-columns: 1fr;
            }

            .as-community-more-card {
                min-height: 190px;
            }

            .as-community-cta {
                padding: 70px 18px;
            }

            .as-community-cta h2 {
                font-size: 31px;
            }

            .as-community-cta p {
                font-size: 14px;
                line-height: 1.75;
            }

            .as-community-cta-btn {
                width: 100%;
                max-width: 300px;
            }
        }


        /* =========================================================
               VERY SMALL PHONES
            ========================================================= */

        @media screen and (max-width: 360px) {

            .as-community-hero-title {
                font-size: 31px;
            }

            .as-community-section-title,
            .as-community-about-title {
                font-size: 27px;
            }

            .as-community-feature-card,
            .as-community-step-card {
                padding-left: 17px;
                padding-right: 17px;
            }

            .as-community-cta h2 {
                font-size: 28px;
            }
        }
    </style>
@endsection


@section('content')
    <main class="as-community-page">


        {{-- =========================================================
         HERO
    ========================================================= --}}

        <section class="as-community-hero">

            <div class="as-community-container">

                <div class="as-community-hero-grid">

                    <div class="as-community-hero-text">

                        <div class="as-community-eyebrow">
                            LGBTQ+ Community
                        </div>

                        <h1 class="as-community-hero-title">
                            LGBTQ+ Community —
                            <span>Connect, Share, Belong</span>
                        </h1>

                        <p class="as-community-hero-description">
                            A space to talk, share experiences, and build real
                            connections with people who get it — no dating angle
                            required.
                        </p>

                        <div class="as-community-hero-buttons">

                            <a href="/register" class="as-community-primary-btn">
                                Join the Community
                            </a>

                        </div>

                        <p class="as-community-founding-line">
                            Early, real, and growing. Join as a founding member
                            and help shape what this community becomes.
                        </p>

                    </div>


                    <div class="as-community-hero-image">

                        <div class="as-community-hero-image-wrap">

                            <img src="{{ asset('images/community/communityheader.png') }}"
                                alt="Diverse LGBTQ+ community celebrating pride together">

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
         WHAT IS THE AFFIRMSPACE COMMUNITY
    ========================================================= --}}

        <section class="as-community-about">

            <div class="as-community-container">

                <div class="as-community-about-grid">

                    <div>

                        <span class="as-community-section-label">
                            What Is the AffirmSpace Community?
                        </span>

                        <h2 class="as-community-about-title">
                            A place to connect
                            <span>without dating.</span>
                        </h2>

                    </div>


                    <div class="as-community-about-content">

                        <p>
                            AffirmSpace Community is built for gay, lesbian,
                            bisexual, transgender, non-binary, pansexual, and
                            asexual people — and anyone still figuring it out —
                            to connect around shared identity, interests, and
                            experience, not just dating.
                        </p>

                        <p>
                            Built by a team based in India, AffirmSpace is designed
                            for LGBTQ+ people worldwide.
                        </p>

                        <p>
                            Community exists because dating isn't the only reason
                            someone comes to AffirmSpace — sometimes you just want
                            to talk to people who understand, without it being
                            about matching with anyone.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
         COMMUNITY FEATURES
    ========================================================= --}}

        <section class="as-community-features">

            <div class="as-community-container">

                <div class="as-community-section-header">

                    <span class="as-community-section-label">
                        Community Features
                    </span>

                    <h2 class="as-community-section-title">
                        Built around shared experience
                    </h2>

                    <p class="as-community-section-intro">
                        Find conversations, people, and spaces that reflect what
                        actually matters to you.
                    </p>

                </div>


                <div class="as-community-feature-grid">


                    {{-- Inclusive Community --}}

                    <div class="as-community-feature-card">

                        <img src="{{ asset('/images/community/Inclusive_Community.jpeg') }}"
                            class="as-community-feature-image" alt="Rainbow heart representing LGBTQ inclusivity">

                        <h3>
                            Inclusive Community
                        </h3>

                        <p>
                            AffirmSpace welcomes people from across the LGBTQ+
                            spectrum. Groups and discussions are organized around
                            identity and shared experience, so you can find people
                            who relate to exactly what you're going through, not
                            just "the LGBTQ+ community" in the abstract.
                        </p>

                    </div>


                    {{-- Meaningful Connections --}}

                    <div class="as-community-feature-card">

                        <img src="{{ asset('/images/community/Meaningful_Connections.jpeg') }}"
                            class="as-community-feature-image"
                            alt="Two hands shaking symbolizing friendship, connection and support">

                        <h3>
                            Meaningful Connections
                        </h3>

                        <p>
                            Meet people through shared interests and ongoing
                            conversations, not a single swipe. Community is built
                            for relationships that develop over time — friendships,
                            support networks, and people you genuinely enjoy
                            talking to.
                        </p>

                    </div>


                    {{-- Safe & Respectful Environment --}}

                    <div class="as-community-feature-card">

                        <img src="{{ asset('/images/community/Safe_Respectful_Environment.jpeg') }}"
                            class="as-community-feature-image" alt="Blue shield with lock showing safety and protection">

                        <h3>
                            Safe & Respectful Environment
                        </h3>

                        <p>
                            Every group and discussion is covered by the same
                            moderation and reporting system as the rest of
                            AffirmSpace. Report or block in one tap, and community
                            guidelines are enforced consistently across groups.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
         HOW AFFIRMSPACE COMMUNITY WORKS
    ========================================================= --}}

        <section class="as-community-steps">

            <div class="as-community-container">

                <div class="as-community-section-header">

                    <span class="as-community-section-label">
                        How It Works
                    </span>

                    <h2 class="as-community-section-title">
                        How the AffirmSpace Community Works
                    </h2>

                    <p class="as-community-section-intro">
                        Join the spaces that interest you, start conversations,
                        and become part of discussions that continue over time.
                    </p>

                </div>


                <div class="as-community-steps-grid">


                    {{-- STEP 1 --}}

                    <div class="as-community-step-card">

                        <div class="as-community-step-number">
                            1
                        </div>

                        <h3>
                            Set Up Your Profile
                        </h3>

                        <p>
                            Create your profile and decide how you want to present
                            your identity within the community.
                        </p>

                    </div>


                    {{-- STEP 2 --}}

                    <div class="as-community-step-card">

                        <div class="as-community-step-number">
                            2
                        </div>

                        <h3>
                            Join or Create Groups
                        </h3>

                        <p>
                            Find groups organized around identity, interests, or
                            shared experience — or start one if the group you're
                            looking for doesn't exist yet.
                        </p>

                    </div>


                    {{-- STEP 3 --}}

                    <div class="as-community-step-card">

                        <div class="as-community-step-number">
                            3
                        </div>

                        <h3>
                            Post, Comment & Discuss
                        </h3>

                        <p>
                            Take part in ongoing discussions, share your own
                            experiences, and follow topics relevant to your journey.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
         WHY COMMUNITY MATTERS
    ========================================================= --}}

        <section class="as-community-why">

            <div class="as-community-why-content">

                <span class="as-community-section-label">
                    Why Community Matters
                </span>

                <h2 class="as-community-section-title">
                    Belonging matters beyond dating.
                </h2>

                <p class="as-community-why-text">
                    For many LGBTQ+ people, finding a space where they feel
                    understood can be transformative. AffirmSpace Community is
                    designed to create a positive digital environment where people
                    can connect, support one another, and feel a genuine sense of
                    belonging — separate from dating, and just as important.
                </p>

            </div>

        </section>


        {{-- =========================================================
         COMMUNITY VALUES
    ========================================================= --}}

        <section class="as-community-values">

            <div class="as-community-container">

                <div class="as-community-section-header">

                    <span class="as-community-section-label">
                        Our Community Values
                    </span>

                    <h2 class="as-community-section-title">
                        The kind of community we're building
                    </h2>

                </div>


                <div class="as-community-values-grid">


                    {{-- VALUE 1 --}}

                    <div class="as-community-value-card">

                        <img src="{{ asset('/images/community/Respect_for_All.png') }}"
                            alt="Hands holding a rainbow heart representing respect for all">

                        <h3>
                            Respect for All
                        </h3>

                        <p>
                            Every identity across the LGBTQ+ spectrum is welcome
                            here, and treated with the same respect — not tolerated,
                            expected.
                        </p>

                    </div>


                    {{-- VALUE 2 --}}

                    <div class="as-community-value-card">

                        <img src="{{ asset('/images/community/Supportive_Conversations.png') }}"
                            alt="Chat bubbles with heart representing supportive conversations">

                        <h3>
                            Supportive Conversations
                        </h3>

                        <p>
                            Community discussions are built for genuine support,
                            not just small talk — a place to ask real questions
                            and share real experiences.
                        </p>

                    </div>


                    {{-- VALUE 3 --}}

                    <div class="as-community-value-card">

                        <img src="{{ asset('/images/community/Safe_Digital_Spaces.png') }}"
                            alt="Shield with locks representing safe digital spaces">

                        <h3>
                            Safe Digital Spaces
                        </h3>

                        <p>
                            Moderation and reporting tools apply across every group
                            and discussion, so participating doesn't mean giving up
                            your sense of safety.
                        </p>

                    </div>


                    {{-- VALUE 4 --}}

                    <div class="as-community-value-card">

                        <img src="{{ asset('/images/community/Meaningful Connections_2.png') }}"
                            alt="Puzzle heart representing meaningful connections">

                        <h3>
                            Meaningful Connections
                        </h3>

                        <p>
                            Groups are organized around what actually matters to
                            you — identity, interests, and shared experience — so
                            the people you meet have real common ground with you.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
         FAQ
    ========================================================= --}}

        <section class="as-community-faq">

            <div class="as-community-container">

                <div class="as-community-section-header">

                    <span class="as-community-section-label">
                        Frequently Asked Questions
                    </span>

                    <h2 class="as-community-section-title">
                        About AffirmSpace Community
                    </h2>

                </div>


                <div class="as-community-faq-container">


                    {{-- FAQ 1 --}}

                    <div class="as-community-faq-item">

                        <button type="button" class="as-community-faq-question">

                            Is Community the same as dating on AffirmSpace?

                        </button>

                        <div class="as-community-faq-answer">

                            <p>
                                No. Community is built for groups, discussions,
                                and connection beyond dating — you can use it
                                whether or not you're also using AffirmSpace
                                Dating.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 2 --}}

                    <div class="as-community-faq-item">

                        <button type="button" class="as-community-faq-question">

                            Can I stay anonymous in community discussions?

                        </button>

                        <div class="as-community-faq-answer">

                            <p>
                                Yes, in spaces where anonymous participation is
                                available, you can take part without putting your
                                public profile identity at the center of the
                                conversation.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 3 --}}

                    <div class="as-community-faq-item">

                        <button type="button" class="as-community-faq-question">

                            How are groups moderated?

                        </button>

                        <div class="as-community-faq-answer">

                            <p>
                                Every group and discussion is covered by
                                AffirmSpace's reporting and moderation system —
                                report or block in one tap.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 4 --}}

                    <div class="as-community-faq-item">

                        <button type="button" class="as-community-faq-question">

                            Can I create my own group?

                        </button>

                        <div class="as-community-faq-answer">

                            <p>
                                Yes. If there isn't already a group for what
                                you're looking for, you can start one.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 5 --}}

                    <div class="as-community-faq-item">

                        <button type="button" class="as-community-faq-question">

                            Is AffirmSpace Community only for India?

                        </button>

                        <div class="as-community-faq-answer">

                            <p>
                                No. AffirmSpace was built by a team based in India
                                but is designed for LGBTQ+ people worldwide.
                            </p>

                        </div>

                    </div>


                </div>

            </div>

        </section>


        {{-- =========================================================
         LOOKING FOR SOMETHING MORE SPECIFIC?
    ========================================================= --}}

        <section class="as-community-more">

            <div class="as-community-container">

                <div class="as-community-section-header">

                    <span class="as-community-section-label">
                        Explore More
                    </span>

                    <h2 class="as-community-section-title">
                        Looking for Something More Specific?
                    </h2>

                </div>


                <div class="as-community-more-grid">


                    {{-- Dating --}}

                    <a href="{{ route('chatAndDating') }}" class="as-community-more-card">

                        <div class="as-community-more-icon">
                            ❤️
                        </div>

                        <h3>
                            Want to date, not just connect?
                        </h3>

                        <p>
                            Explore LGBTQ+ dating built around real connections.
                        </p>

                        <span class="as-community-more-link">
                            Explore LGBTQ+ Dating →
                        </span>

                    </a>


                    {{-- Chat --}}

                    <a href="{{ route('chat') }}" class="as-community-more-card">

                        <div class="as-community-more-icon">
                            💬
                        </div>

                        <h3>
                            Want to talk one-on-one or in private groups?
                        </h3>

                        <p>
                            Connect through LGBTQ+ chat and conversations.
                        </p>

                        <span class="as-community-more-link">
                            Explore LGBTQ+ Chat →
                        </span>

                    </a>


                    {{-- Counselling --}}

                    <a href="{{ route('counselling') }}" class="as-community-more-card">

                        <div class="as-community-more-icon">
                            🧠
                        </div>

                        <h3>
                            Need professional support?
                        </h3>

                        <p>
                            Find LGBTQ+-friendly counselling support.
                        </p>

                        <span class="as-community-more-link">
                            Find an LGBTQ+-friendly counsellor →
                        </span>

                    </a>


                    {{-- Events --}}

                    <a href="{{ route('events') }}" class="as-community-more-card">

                        <div class="as-community-more-icon">
                            📅
                        </div>

                        <h3>
                            Want to meet people in person?
                        </h3>

                        <p>
                            Discover upcoming LGBTQ+ events and gatherings.
                        </p>

                        <span class="as-community-more-link">
                            See upcoming LGBTQ+ Events →
                        </span>

                    </a>

                </div>

            </div>

        </section>


        {{-- =========================================================
         FINAL CTA
    ========================================================= --}}

        <section class="as-community-cta">

            <div class="as-community-container">

                <h2>
                    Become Part of the Community
                </h2>

                <p>
                    Connect with people who share your experiences and values.
                </p>

                <a href="/register" class="as-community-cta-btn">

                    Join the Community

                </a>

            </div>

        </section>


    </main>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document
                .querySelectorAll('.as-community-faq-question')
                .forEach(function(question) {

                    question.addEventListener('click', function() {

                        const answer = question.nextElementSibling;

                        if (!answer) {
                            return;
                        }

                        const isActive =
                            question.classList.contains('active');


                        /* Close all other FAQ items */

                        document
                            .querySelectorAll('.as-community-faq-question')
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


                        /* Toggle selected FAQ */

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
