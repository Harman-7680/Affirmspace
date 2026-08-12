@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Get confidential LGBTQ+ counselling and mental health support online. Talk to trained, identity-affirming counsellors in a safe space.">

    <title>LGBTQ+ Counselling & Mental Health Support | AffirmSpace</title>
    <meta name="author" content="AffirmSpace">
    <meta name="keywords"
        content="LGBTQ+ counselling, LGBTQ+ mental health support, LGBTQ+ therapists / counsellors, LGBTQ+ counselling platform, LGBTQ+ mental wellness	">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- WebPage Schema -->
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "LGBTQ+ Counselling & Therapy Support",
  "url": "https://affirmspace.com/lgbtq-mental-health-counselling",
  "description": "Connect with verified LGBTQ+ affirming counsellors and therapists for mental health support, emotional wellbeing, personal growth, relationship guidance, and identity-related concerns."
}
</script>

    <!-- FAQ Schema -->
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What mental health support is available on Affirmspace?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Affirmspace helps users connect with verified counsellors and therapists who provide support for emotional wellbeing, personal growth, relationships, stress management, and identity-related concerns."
      }
    },
    {
      "@type": "Question",
      "name": "Are counsellors and therapists verified on Affirmspace?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Affirmspace reviews professional qualifications and supporting documentation before approving counsellors and therapists on the platform."
      }
    },
    {
      "@type": "Question",
      "name": "Can I find LGBTQ+ affirming therapists on Affirmspace?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Affirmspace helps users connect with verified counsellors and therapists who provide LGBTQ+ affirming support in a respectful and inclusive environment."
      }
    },
    {
      "@type": "Question",
      "name": "Can therapy help with stress, relationships, and self-confidence?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Many people seek counselling and therapy for support with stress, relationships, self-confidence, emotional wellbeing, identity exploration, and personal development."
      }
    },
    {
      "@type": "Question",
      "name": "Can I access counselling online through Affirmspace?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Users can browse verified counsellor and therapist profiles and access available online counselling and support services through the platform."
      }
    },
    {
      "@type": "Question",
      "name": "Who can use counselling services on Affirmspace?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Affirmspace welcomes LGBTQ+ individuals and supportive allies seeking professional guidance, emotional support, personal growth, and mental wellbeing resources."
      }
    }
  ]
}
</script>
@endsection

@section('css')
    <style>
        .therapy-hero {
            background: #fffaf8;
            padding: 40px 0 70px;
            overflow: hidden;
        }

        .therapy-container {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        .therapy-grid {
            display: grid;
            grid-template-columns: 46% 54%;
            gap: 35px;
            align-items: center;
        }

        .therapy-tag {
            display: inline-block;
            color: #ff6a8b;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin-bottom: 18px;
        }

        .therapy-content h1 {
            font-size: 64px;
            line-height: 1.02;
            color: #222;
            font-weight: 700;
            margin-bottom: 18px;
            letter-spacing: -2px;
        }

        .therapy-content h1 span {
            color: #ff4f7d;
            font-style: italic;
        }

        .therapy-content p {
            color: #666;
            font-size: 17px;
            line-height: 1.8;
            max-width: 470px;
            margin-bottom: 28px;
        }

        .therapy-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 45px;
            flex-wrap: wrap;
        }

        .therapy-btn {
            padding: 15px 24px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .primary-btn {
            background: linear-gradient(90deg, #ff6a7a, #ff5f8f);
            color: white;
        }

        .secondary-btn {
            border: 1px solid #ffb8c8;
            color: #ff5b84;
            background: white;
        }

        .therapy-btn:hover {
            transform: translateY(-2px);
        }

        .therapy-features {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .therapy-feature {
            text-align: left;
        }

        .feature-icon {
            /* width:42px; */
            /* height:42px; */
            border-radius: 12px;
            /* background:#fff1ef; */
            /* display:flex;
                                align-items:center;
                                justify-content:center; */
            margin-bottom: 12px;
            font-size: 18px;
        }

        .therapy-feature h4 {
            font-size: 13px;
            color: #222;
            margin-bottom: 6px;
            font-weight: 700;
            line-height: 1.4;
        }

        .therapy-feature p {
            font-size: 11px;
            color: #777;
            line-height: 1.6;
            margin: 0;
        }

        .therapy-image {
            position: relative;
        }

        .therapy-image img {
            width: 100%;
            border-radius: 32px;
            display: block;
        }

        /* FLOATING CARD */

        .therapy-floating-card {
            position: absolute;
            left: 40px;
            bottom: 20px;
            background: white;
            border-radius: 24px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            width: 75%;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .floating-icon {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: #fff1ef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ff5f8f;
            font-size: 26px;
            flex-shrink: 0;
        }

        .floating-text h3 {
            font-size: 20px;
            line-height: 1.3;
            color: #222;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .floating-text p {
            font-size: 14px;
            color: #777;
            line-height: 1.6;
            margin: 0;
        }

        .floating-heart {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #ff5f8f;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        @media(max-width:1100px) {

            .therapy-grid {
                grid-template-columns: 1fr;
            }

            .therapy-content {
                text-align: center;
            }

            .therapy-content p {
                margin-left: auto;
                margin-right: auto;
            }

            .therapy-buttons {
                justify-content: center;
            }

            .therapy-features {
                grid-template-columns: repeat(2, 1fr);
            }

            .therapy-feature {
                text-align: center;
            }

            .feature-icon {
                margin: auto auto 12px;
            }

            .therapy-floating-card {
                width: 85%;
                left: 50%;
                transform: translateX(-50%);
            }
        }

        @media(max-width:768px) {

            .therapy-content h1 {
                font-size: 42px;
            }

            .therapy-features {
                grid-template-columns: 1fr 1fr;
                gap: 25px;
            }

            .therapy-floating-card {
                position: relative;
                width: 100%;
                left: 0;
                bottom: 0;
                transform: none;
                margin-top: 20px;
            }

            .therapy-image img {
                border-radius: 24px;
            }

            .therapy-floating-card {
                border-radius: 20px;
            }
        }

        @media(max-width:520px) {

            .therapy-content h1 {
                font-size: 34px;
            }

            .therapy-buttons {
                flex-direction: column;
            }

            .therapy-btn {
                width: 100%;
            }

            .therapy-features {
                grid-template-columns: 1fr;
            }

            .therapy-floating-card {
                flex-direction: column;
                text-align: center;
            }
        }

        .support-section {
            padding: 40px 0 90px;
            background: white;
        }

        .support-container {
            /* max-width:1200px; */
            margin: auto;
            padding: 0 20px;
        }

        .support-grid {
            background: linear-gradient(90deg, #fdf3ef, #fff4f5);
            border-radius: 30px;
            /* padding:55px; */
            display: grid;
            grid-template-columns: 50% 50%;
            gap: 40px;
            align-items: center;
            overflow: hidden;
        }

        .support-left {
            position: relative;
            min-height: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .support-left video {
            width: 100%;
            max-width: 700px;
            max-height: fit-content;
            height: 520px;
            object-fit: cover;
            border-radius: 30px;
            z-index: 2;
            position: relative;
            display: block;
        }

        .support-left::before {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle,
                    rgba(255, 220, 214, 0.7) 0%,
                    rgba(255, 220, 214, 0.2) 40%,
                    transparent 70%);
            z-index: 1;
        }

        .support-tag {
            color: #ff6d8b;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.6px;
            display: block;
            margin-bottom: 24px;
        }

        .support-right h2 {
            font-size: 58px;
            line-height: 1.08;
            color: #222;
            font-weight: 700;
            margin-bottom: 24px;
            letter-spacing: -2px;
            max-width: 540px;
        }

        .support-right h2 span {
            color: #ff5f8f;
            font-style: italic;
        }

        .support-right p {
            color: #666;
            font-size: 18px;
            line-height: 1.9;
            max-width: 500px;
            margin-bottom: 35px;
        }

        .support-link {
            color: #ff5f8f;
            text-decoration: none;
            font-weight: 700;
            font-size: 17px;
        }

        @media(max-width:1100px) {

            .support-grid {
                grid-template-columns: 1fr;
                padding: 40px;
            }

            .support-right {
                text-align: center;
            }

            .support-right h2,
            .support-right p {
                margin-left: auto;
                margin-right: auto;
            }

            .support-left {
                min-height: 480px;
            }
        }

        @media(max-width:768px) {

            .support-grid {
                padding: 30px 20px;
                border-radius: 24px;
            }

            .support-right h2 {
                font-size: 40px;
            }

            .support-right p {
                font-size: 16px;
            }

            .support-left {
                min-height: 420px;
            }

            .support-left video {
                width: 240px;
                height: 240px;
            }

            .support-badge {
                width: 85px;
                height: 85px;
            }

            .support-badge span {
                font-size: 20px;
            }

            .support-badge p {
                font-size: 10px;
            }

            .badge-1 {
                left: 10px;
            }

            .badge-3 {
                right: 10px;
            }
        }

        @media(max-width:520px) {

            .support-right h2 {
                font-size: 32px;
                line-height: 1.2;
            }

            .support-left {
                min-height: 360px;
            }

            .support-left::before {
                width: 320px;
                height: 320px;
            }

            .support-left video {
                width: 190px;
                height: 500px;
                border-radius: 24px;
            }

            .support-badge {
                width: 72px;
                height: 72px;
            }

            .support-badge span {
                font-size: 16px;
                margin-bottom: 5px;
            }

            .support-badge p {
                font-size: 9px;
                line-height: 1.2;
            }
        }


        /* CTA */

        .counsel-cta {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            padding: 0px 0;
            margin: 0 20px;
            border-radius: 15px;
        }

        .cta-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .cta-text h2 {
            font-size: 34px;
            margin-bottom: 15px;
        }

        .cta-text p {
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .cta-image img {
            max-width: 350px;
        }

        .counsel-cta .btn-primary {
            margin-top: 20px;
        }

        @media(max-width:900px) {

            .hero-flex,
            .cta-flex {
                flex-direction: column;
                text-align: center;
            }

            .mid-grid {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 34px;
            }

        }
    </style>

    <style>
        .therapy-features-wrapper {
            padding: 40px 0;
        }

        .therapy-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Individual Feature Card */
        .therapy-feature {
            background: #ffffff;
            border-radius: 16px;
            padding: 32px 24px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .therapy-feature:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        .therapy-feature h4 {
            font-size: 1.35rem;
            margin-bottom: 12px;
            color: #1f2937;
        }

        .therapy-feature p {
            color: #6b7280;
            line-height: 1.6;
        }

        /* Responsive Adjustments */
        @media (max-width: 640px) {
            .therapy-features-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .therapy-feature {
                padding: 28px 20px;
            }
        }
    </style>

    <style>
        .therapy-hero-banner {
            background: linear-gradient(90deg, #FF6B5E, #FF4A8F);
            border-radius: 28px;
            padding: 23px 9px;
            /* max-width: 1250px; */
            margin: 40px 20px;
            color: white;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .therapy-hero-inner {
            display: flex;
            align-items: center;
            gap: 70px;
            max-width: 1150px;
            margin: 0 auto;
        }

        /* Left Image */
        .hero-image-side {
            flex: 1;
        }

        .hero-image {
            width: 100%;
            max-width: 380px;
            height: auto;
            filter: drop-shadow(20px 25px 40px rgba(0, 0, 0, 0.25));
        }

        /* Right Content */
        .hero-text-side {
            flex: 1;
        }

        .pre-title {
            font-size: 1.15rem;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .main-title {
            font-size: 2.75rem;
            line-height: 1.15;
            font-weight: 700;
            margin-bottom: 25px;
        }

        /* Button + Flexible Text */
        .btn-flexible-wrapper {
            margin-bottom: 25px;
        }

        .book-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            color: #e83e8c;
            padding: 16px 34px;
            border-radius: 50px;
            font-size: 1.18rem;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .book-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.25);
        }

        .flexible-text {
            margin-top: 12px;
            font-size: 1.08rem;
            opacity: 0.92;
        }

        /* Three Features Section */
        .features-list {
            display: flex;
            flex-wrap: wrap;
            gap: 18px 35px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.07rem;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 992px) {
            .therapy-hero-inner {
                flex-direction: column;
                text-align: center;
                gap: 40px;
            }

            .hero-image {
                max-width: 320px;
            }

            .main-title {
                font-size: 2.4rem;
            }
        }

        @media (max-width: 640px) {
            .therapy-hero-banner {
                padding: 40px 20px;
                border-radius: 20px;
            }

            .main-title {
                font-size: 2.05rem;
            }

            .features-list {
                justify-content: center;
            }
        }

        /* =========================================================
       AFFIRMSPACE COUNSELLING SECTION
    ========================================================= */

        .af-counselling-section {
            position: relative;
            width: 100%;
            overflow: hidden;

            padding: 70px 30px 55px;

            background:
                linear-gradient(135deg,
                    #fff9f7 0%,
                    #fff3f4 50%,
                    #fff8f7 100%);

            color: #111a45;
        }


        /* =========================================================
       BACKGROUND DECORATIONS
    ========================================================= */

        .af-counselling-decoration {
            position: absolute;
            pointer-events: none;

            border: 2px solid rgba(244, 45, 111, 0.10);
            border-radius: 50%;
        }


        .af-decoration-top {
            width: 360px;
            height: 360px;

            right: -170px;
            top: -170px;
        }


        .af-decoration-bottom {
            width: 300px;
            height: 300px;

            left: -170px;
            bottom: -180px;
        }


        /* =========================================================
       HEADER
    ========================================================= */

        .af-counselling-header {
            position: relative;
            z-index: 2;

            max-width: 850px;
            margin: 0 auto 35px;

            text-align: center;
        }


        .af-counselling-eyebrow {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 9px;

            margin-bottom: 15px;

            color: #ed2b68;

            font-size: 16px;
            font-weight: 700;

            letter-spacing: 2.5px;
        }


        .af-counselling-eyebrow span {
            color: #f3a7ba;
            font-size: 15px;
        }


        /* Main heading */

        .af-counselling-header h2 {
            margin: 0;

            color: #121b46;

            font-size: clamp(42px, 5vw, 64px);

            line-height: 1.08;

            font-weight: 700;

            letter-spacing: -2px;
        }


        .af-counselling-header h2 em {
            color: #ed2b68;
            font-style: italic;
        }


        /* Description */

        .af-counselling-header p {
            max-width: 760px;

            margin: 18px auto 0;

            color: #3d3e47;

            font-size: 21px;

            line-height: 1.5;
        }


        /* =========================================================
       SINGLE COUNSELLING IMAGE
    ========================================================= */

        .af-counselling-visual {
            position: relative;
            z-index: 2;

            width: 100%;
            max-width: 1500px;

            margin: 0 auto;

            display: flex;
            justify-content: center;
            align-items: center;
        }


        .af-counselling-visual img {
            display: block;

            width: 100%;
            max-width: 1500px;

            height: auto;

            object-fit: contain;

            border: 0;
        }


        /* =========================================================
       SUPPORT MESSAGE
    ========================================================= */

        .af-support-message {
            position: relative;
            z-index: 3;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 18px;

            max-width: 800px;

            margin: 10px auto 0;
        }


        .af-support-icon {
            width: 64px;
            height: 64px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #ffe4eb;

            color: #ed2b68;
        }


        .af-support-icon svg {
            width: 39px;
            height: 39px;
        }


        .af-support-message p {
            margin: 0;

            color: #111a45;

            font-size: 19px;

            line-height: 1.45;
        }


        .af-support-message strong {
            color: #ed2b68;
        }


        /* =========================================================
       CTA
    ========================================================= */

        .af-counselling-cta {
            position: relative;
            z-index: 3;

            display: flex;
            justify-content: center;

            margin-top: 16px;
        }


        .af-explore-button {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 23px;

            min-width: 315px;

            padding: 16px 30px;

            border-radius: 50px;

            background:
                linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            color: #ffffff !important;

            text-decoration: none;

            font-size: 20px;

            font-weight: 600;

            box-shadow:
                0 12px 30px rgba(221, 36, 118, 0.20);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .af-explore-button:hover {
            transform: translateY(-3px);

            box-shadow:
                0 16px 35px rgba(221, 36, 118, 0.28);
        }


        .af-button-arrow {
            font-size: 27px;
            line-height: 1;
        }


        /* =========================================================
       TRUST FEATURES
    ========================================================= */

        .af-trust-features {
            position: relative;
            z-index: 3;

            max-width: 900px;

            margin: 28px auto 0;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 22px;
        }


        .af-trust-item {
            display: flex;

            align-items: center;

            gap: 10px;

            white-space: nowrap;

            color: #10183f;

            font-size: 14px;
        }


        .af-trust-icon {
            width: 42px;
            height: 42px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #ffe5eb;

            color: #ed2b68;
        }


        .af-trust-icon svg {
            width: 21px;
            height: 21px;
        }


        .af-trust-divider {
            width: 1px;
            height: 28px;

            background: rgba(237, 43, 104, 0.18);
        }


        /* =========================================================
       TABLET
    ========================================================= */

        @media (max-width: 1000px) {

            .af-counselling-section {
                padding:
                    60px 22px 50px;
            }


            .af-counselling-header h2 {
                font-size: 48px;
            }


            .af-counselling-header p {
                font-size: 19px;
            }


            .af-counselling-visual img {
                width: 100%;
            }


            .af-support-message {
                max-width: 700px;
            }

        }


        /* =========================================================
       MOBILE
    ========================================================= */

        @media (max-width: 768px) {

            .af-counselling-section {
                padding:
                    50px 15px 45px;
            }


            /* Header */

            .af-counselling-header {
                margin-bottom: 25px;
            }


            .af-counselling-eyebrow {
                font-size: 12px;
                letter-spacing: 1.7px;
            }


            .af-counselling-header h2 {
                font-size: 38px;
                letter-spacing: -1.5px;
            }


            .af-counselling-header p {
                margin-top: 15px;

                font-size: 16px;

                line-height: 1.5;
            }


            /* Image */

            .af-counselling-visual {
                width: 100%;
            }


            .af-counselling-visual img {
                width: 100%;
                height: auto;
            }


            /* Support */

            .af-support-message {
                align-items: flex-start;

                gap: 12px;

                margin-top: 22px;
            }


            .af-support-icon {
                width: 48px;
                height: 48px;
            }


            .af-support-icon svg {
                width: 30px;
                height: 30px;
            }


            .af-support-message p {
                font-size: 15px;
            }


            /* CTA */

            .af-explore-button {
                width: 100%;

                min-width: 0;

                padding: 15px 20px;

                font-size: 17px;
            }


            /* Trust */

            .af-trust-features {
                display: grid;

                grid-template-columns: 1fr 1fr;

                gap: 14px;

                margin-top: 25px;
            }


            .af-trust-divider {
                display: none;
            }


            .af-trust-item {
                font-size: 12px;
            }


            .af-trust-icon {
                width: 36px;
                height: 36px;
            }


            .af-trust-icon svg {
                width: 19px;
                height: 19px;
            }

        }


        /* =========================================================
       SMALL MOBILE
    ========================================================= */

        @media (max-width: 420px) {

            .af-counselling-section {
                padding-left: 12px;
                padding-right: 12px;
            }


            .af-counselling-header h2 {
                font-size: 33px;
            }


            .af-counselling-header p {
                font-size: 15px;
            }


            .af-trust-item {
                font-size: 11px;
                gap: 7px;
            }

        }
    </style>
@endsection

@section('content')
    <!-- HERO SECTION -->

    <section class="therapy-hero">

        <div class="therapy-container">

            <div class="therapy-grid">

                <!-- LEFT CONTENT -->

                <div class="therapy-content">

                    <span class="therapy-tag">
                        ♡ COUNSELLING THAT CARES
                    </span>

                    <h1>
                        Get Counselling from
                        <span>Verified</span>
                        Therapists
                    </h1>

                    <p>
                        Professional support. Personal care.
                        Start your journey toward a healthier,
                        happier you.
                    </p>

                    <!-- BUTTONS -->

                    <div class="therapy-buttons">

                        <a href="{{ 'register' }}?role=1" class="therapy-btn primary-btn">
                            📅 Join as a Doctor
                        </a>
                        <!-- <a href="{{ 'register' }}?role=1" class="secondary-btn">I'm a Doctor / Therapist</a> -->

                        <a href="{{ 'login' }}" class="therapy-btn secondary-btn">
                            💬 Book Appointment
                        </a>
                    </div>
                </div>

                <div class="therapy-image">
                    <img src="/images/counselling/Header_Image_Counselling.png" alt="Therapist session">
                </div>
            </div>
        </div>

    </section>

    <div class="therapy-features-wrapper" style="margin-top: 10px;">
        <div class="therapy-features-grid">

            <!-- Feature 1 -->
            <div class="therapy-feature">
                <div class="feature-icon">🔒</div>
                <h4>100% Confidential</h4>

                <p>Your privacy is our priority</p>
            </div>

            <!-- Feature 2 -->
            <div class="therapy-feature">
                <div class="feature-icon">🛡️</div>
                <h4>Verified Therapists</h4>

                <p>Qualified & experienced professionals</p>
                {{-- <h4>Personalized Approach</h4>
                            <p>Tailored therapy sessions for your unique needs</p> --}}
            </div>

            <!-- Feature 3 -->
            <div class="therapy-feature">
                <div class="feature-icon">🩺</div>
                <h4>Safe & Secure</h4>

                <p>Fully compliant platform</p>
                {{-- <h4>Expert Therapists</h4>
                            <p>Experienced and licensed professionals</p> --}}
            </div>

            <!-- Feature 4 -->
            <div class="therapy-feature">
                <div class="feature-icon">⏰</div>
                <h4>Flexible Sessions</h4>

                <p>Online or in person as per your comfort</p>
                {{-- <h4>Confidential & Safe</h4>
                            <p>Your privacy is our top priority</p> --}}
            </div>

        </div>
    </div>

    <section class="support-section">

        <div class="support-container">

            <div class="support-grid">

                <!-- LEFT SIDE -->

                <div class="support-left">

                    <!-- YOUR VIDEO HERE -->

                    <video autoplay muted loop playsinline>
                        <source src="/images/counselling/counseling_video.mp4" type="video/mp4">
                    </video>

                </div>

                <!-- RIGHT SIDE -->

                <div class="support-right">

                    <span class="support-tag">
                        WE CAN HELP YOU WITH
                    </span>

                    <h2>
                        Whatever you’re
                        going through, you
                        don’t have to face it
                        <span>alone.</span>
                    </h2>

                    <p>
                        Our therapists help you navigate life’s challenges
                        and build skills for a more fulfilling life.
                    </p>

                    <a href="#" class="support-link">
                        Explore All Areas →
                    </a>

                </div>

            </div>

        </div>

    </section>

    @include('seo.how_affirmspace_work')


    <section class="af-counselling-section">

        <!-- Decorative background -->
        <div class="af-counselling-decoration af-decoration-top"></div>
        <div class="af-counselling-decoration af-decoration-bottom"></div>

        <!-- Heading -->
        <div class="af-counselling-header">

            <div class="af-counselling-eyebrow">
                <span>♥</span>
                SOMETIMES, YOU JUST NEED
            </div>

            <h2>
                Somewhere to <em>put it down.</em>
            </h2>

            <p>
                You don’t have to carry everything alone.
                Talking about what you’re going through can be
                the first step toward feeling lighter.
            </p>

        </div>


        <!-- YOUR SINGLE IMAGE -->
        <div class="af-counselling-visual">

            <img src="/images/counselling/new.png" alt="Counselling support at AffirmSpace">

        </div>


        <!-- Privacy / Support Message -->
        <div class="af-support-message">

            <div class="af-support-icon">

                <svg viewBox="0 0 48 48" aria-hidden="true">

                    <path d="M24 5
                        L39 11
                        V22
                        C39 32 32 39 24 43
                        C16 39 9 32 9 22
                        V11Z" fill="none" stroke="currentColor" stroke-width="2.5" />

                    <path d="M24 17
                        C20 12 14 15 14 20
                        C14 25 24 31 24 31
                        C24 31 34 25 34 20
                        C34 15 28 12 24 17Z" fill="none" stroke="currentColor" stroke-width="2" />

                </svg>

            </div>

            <p>
                At AffirmSpace, your conversations are private,
                supportive, and
                <strong>always judgment-free.</strong>
            </p>

        </div>


        <!-- CTA -->
        <!-- <div class="af-counselling-cta">

            <a href="/counselling" class="af-explore-button">
                <span>Explore Counselling</span>
                <span class="af-button-arrow">→</span>
            </a>

        </div> -->


        <!-- Trust Features -->
        <div class="af-trust-features">

            <!-- Confidential -->
            <div class="af-trust-item">

                <div class="af-trust-icon">

                    <svg viewBox="0 0 24 24">

                        <rect x="5" y="10" width="14" height="10" rx="2" fill="none" stroke="currentColor"
                            stroke-width="1.8" />

                        <path d="M8 10V7
                            C8 4 16 4 16 7V10" fill="none" stroke="currentColor" stroke-width="1.8" />

                    </svg>

                </div>

                <span>100% Confidential</span>

            </div>


            <div class="af-trust-divider"></div>


            <!-- Therapists -->
            <div class="af-trust-item">

                <div class="af-trust-icon">

                    <svg viewBox="0 0 24 24">

                        <circle cx="12" cy="8" r="4" fill="none" stroke="currentColor"
                            stroke-width="1.8" />

                        <path d="M5 21
                            C5 16 8 14 12 14
                            C16 14 19 16 19 21" fill="none" stroke="currentColor" stroke-width="1.8" />

                    </svg>

                </div>

                <span>Verified Therapists</span>

            </div>


            <div class="af-trust-divider"></div>


            <!-- Safe -->
            <div class="af-trust-item">

                <div class="af-trust-icon">

                    <svg viewBox="0 0 24 24">

                        <path d="M12 3
                            L19 6
                            V11
                            C19 16 16 19 12 21
                            C8 19 5 16 5 11
                            V6Z" fill="none" stroke="currentColor" stroke-width="1.8" />

                    </svg>

                </div>

                <span>Safe &amp; Secure</span>

            </div>


            <div class="af-trust-divider"></div>


            <!-- Flexible -->
            <div class="af-trust-item">

                <div class="af-trust-icon">

                    <svg viewBox="0 0 24 24">

                        <rect x="4" y="5" width="16" height="15" rx="2" fill="none"
                            stroke="currentColor" stroke-width="1.8" />

                        <path d="M8 3V7
                            M16 3V7
                            M4 10H20" fill="none" stroke="currentColor" stroke-width="1.8" />

                    </svg>

                </div>

                <span>Flexible Sessions</span>

            </div>

        </div>

    </section>


    <div class="therapy-hero-banner">
        <div class="therapy-hero-inner">

            <!-- Left Side - Image -->
            <div class="hero-image-side">
                <img src="/images/counselling/chair.png" alt="Therapy Chair" class="hero-image">
            </div>

            <!-- Right Side - Content (This is ONE section but visually divided) -->
            <div class="hero-text-side">

                <p class="pre-title">READY TO TAKE THE FIRST STEP?</p>

                <h1 class="main-title">
                    You deserve support.<br>
                    Let’s work together.
                </h1>

                <!-- Three Features -->
                <div class="features-list">
                    <div class="feature-item">
                        <span class="check">✔</span> Judgment-free support
                    </div>
                    <div class="feature-item">
                        <span class="check">✔</span> Personalized care
                    </div>
                    <div class="feature-item">
                        <span class="check">✔</span> Lasting change
                    </div>
                </div>

            </div>
            <div class="btn-flexible-wrapper">
                <a href="#" class="book-btn">
                    📅 Book Your Session
                </a>
                <p class="flexible-text">Flexible slots • Online & Offline</p>
            </div>

        </div>
    </div>
@endsection
